import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_inappwebview/flutter_inappwebview.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:permission_handler/permission_handler.dart';

// ==========================================
// CONFIGURATION
// ==========================================
// Define the default URL that the WebView app will load.
// You can change this to your local server IP (e.g. 'http://192.168.1.100:8000') for testing,
// or your production domain (e.g. 'https://blocinfra.com').
const String defaultAppUrl = "https://bloc-infra.rawsio.com/contractor/dashboard";
const String appTitle = "BLOC INFRA";

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // Set Android specific WebView configuration
  if (Platform.isAndroid) {
    await InAppWebViewController.setWebContentsDebuggingEnabled(kDebugMode);
  }

  // Set system UI style (dark mode bar styling)
  SystemChrome.setSystemUIOverlayStyle(const SystemUiOverlayStyle(
    statusBarColor: Colors.transparent,
    statusBarIconBrightness: Brightness.light,
    statusBarBrightness: Brightness.dark,
  ));

  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: appTitle,
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        brightness: Brightness.dark,
        primaryColor: const Color(0xFF0F766E), // Teal theme matching Bloc Infra
        scaffoldBackgroundColor: const Color(0xFF0F1114), // Dark background matching website
        colorScheme: const ColorScheme.dark(
          primary: Color(0xFF0F766E),
          secondary: Color(0xFFB3D33C), // Accent lime/green matching navbar
          surface: Color(0xFF0F1114),
        ),
        useMaterial3: true,
      ),
      home: const WebViewScreen(),
    );
  }
}

class WebViewScreen extends StatefulWidget {
  const WebViewScreen({super.key});

  @override
  State<WebViewScreen> createState() => _WebViewScreenState();
}

class _WebViewScreenState extends State<WebViewScreen> {
  final GlobalKey webViewKey = GlobalKey();
  InAppWebViewController? webViewController;
  PullToRefreshController? pullToRefreshController;
  
  double progress = 0;
  bool isLoading = true;
  bool isFirstLoad = true;
  bool isNoInternet = false;
  String currentUrl = defaultAppUrl;

  late InAppWebViewSettings settings;

  @override
  void initState() {
    super.initState();
    
    // Request permission on app launch
    _requestPermissions();

    // Initialize Webview settings
    settings = InAppWebViewSettings(
      useShouldOverrideUrlLoading: true,
      mediaPlaybackRequiresUserGesture: false,
      allowsInlineMediaPlayback: true,
      iframeAllow: "camera; microphone; geolocation",
      iframeAllowFullscreen: true,
      useOnDownloadStart: true,
      javaScriptEnabled: true,
      domStorageEnabled: true,
      databaseEnabled: true,
      geolocationEnabled: true,
      supportZoom: true,
      builtInZoomControls: true,
      displayZoomControls: false,
      mixedContentMode: MixedContentMode.MIXED_CONTENT_ALWAYS_ALLOW,
      safeBrowsingEnabled: true,
      allowFileAccessFromFileURLs: true,
      allowUniversalAccessFromFileURLs: true,
    );

    // Setup pull-to-refresh controller
    pullToRefreshController = kIsWeb
        ? null
        : PullToRefreshController(
            settings: PullToRefreshSettings(
              color: const Color(0xFFB3D33C),
              backgroundColor: const Color(0xFF0F1114),
            ),
            onRefresh: () async {
              if (Platform.isAndroid) {
                webViewController?.reload();
              } else if (Platform.isIOS) {
                webViewController?.loadUrl(
                  urlRequest: URLRequest(url: await webViewController?.getUrl()),
                );
              }
            },
          );
  }

  Future<void> _requestPermissions() async {
    // Request Camera, Microphone, and Geolocation natively
    Map<Permission, PermissionStatus> statuses = await [
      Permission.camera,
      Permission.microphone,
      Permission.location,
      Permission.locationWhenInUse,
    ].request();

    if (kDebugMode) {
      print("Camera native permission status: ${statuses[Permission.camera]}");
      print("Microphone native permission status: ${statuses[Permission.microphone]}");
      print("Location native permission status: ${statuses[Permission.location]}");
    }
  }

  @override
  Widget build(BuildContext context) {
    return PopScope(
      canPop: false,
      onPopInvokedWithResult: (didPop, result) async {
        if (didPop) return;
        
        // Handle android physical back button: navigate back inside webview history
        if (webViewController != null) {
          if (await webViewController!.canGoBack()) {
            webViewController!.goBack();
            return;
          }
        }
        
        // Confirm exit if we cannot go back further
        _showExitConfirmation();
      },
      child: Scaffold(
        body: SafeArea(
          child: Stack(
            children: [
              // WebView Widget
              InAppWebView(
                key: webViewKey,
                initialUrlRequest: URLRequest(url: WebUri(defaultAppUrl)),
                initialSettings: settings,
                pullToRefreshController: pullToRefreshController,
                onWebViewCreated: (controller) {
                  webViewController = controller;
                },
                onLoadStart: (controller, url) {
                  setState(() {
                    currentUrl = url.toString();
                    isLoading = true;
                  });
                },
                onPermissionRequest: (controller, request) async {
                  // Grants camera/microphone/location permissions requested by web content
                  return PermissionResponse(
                    resources: request.resources,
                    action: PermissionResponseAction.GRANT,
                  );
                },
                onGeolocationPermissionsShowPrompt: (controller, origin) async {
                  // Grant geolocation permission to origin
                  return GeolocationPermissionShowPromptResponse(
                    origin: origin,
                    allow: true,
                    retain: true,
                  );
                },
                shouldOverrideUrlLoading: (controller, navigationAction) async {
                  var uri = navigationAction.request.url;

                  if (![
                    "http",
                    "https",
                    "file",
                    "chrome",
                    "data",
                    "javascript",
                    "about"
                  ].contains(uri?.scheme)) {
                    if (await canLaunchUrl(uri!)) {
                      // Launch external apps (e.g. tel:, mailto:, whatsapp:, etc.)
                      await launchUrl(uri);
                      return NavigationActionPolicy.CANCEL;
                    }
                  }

                  return NavigationActionPolicy.ALLOW;
                },
                onLoadStop: (controller, url) async {
                  pullToRefreshController?.endRefreshing();
                  setState(() {
                    currentUrl = url.toString();
                    isLoading = false;
                    isFirstLoad = false;
                    isNoInternet = false;
                  });
                },
                onReceivedError: (controller, request, error) {
                  pullToRefreshController?.endRefreshing();
                  if (request.isForMainFrame ?? true) {
                    setState(() {
                      isNoInternet = true;
                      isLoading = false;
                    });
                  }
                },
                onProgressChanged: (controller, progressVal) {
                  if (progressVal == 100) {
                    pullToRefreshController?.endRefreshing();
                  }
                  setState(() {
                    progress = progressVal / 100;
                    if (progressVal == 100) {
                      isLoading = false;
                      isFirstLoad = false;
                    }
                  });
                },
                onDownloadStartRequest: (controller, downloadStartRequest) async {
                  // Handle file downloads
                  final url = downloadStartRequest.url;
                  if (await canLaunchUrl(url)) {
                    await launchUrl(
                      url,
                      mode: LaunchMode.externalApplication,
                    );
                    _showToast("Download started...");
                  } else {
                    _showToast("Could not download file.");
                  }
                },
              ),

              // Progress Indicator at top of screen
              if (isLoading && !isNoInternet)
                Align(
                  alignment: Alignment.topCenter,
                  child: SizedBox(
                    height: 3,
                    child: LinearProgressIndicator(
                      value: progress > 0 ? progress : null,
                      backgroundColor: Colors.transparent,
                      valueColor: const AlwaysStoppedAnimation<Color>(Color(0xFFB3D33C)),
                    ),
                  ),
                ),

              // Centered Loading Spinner (for first initial load)
              if (isFirstLoad && !isNoInternet)
                Container(
                  color: const Color(0xFF0F1114),
                  child: Center(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        // App title
                        const Text(
                          appTitle,
                          style: TextStyle(
                            color: Color(0xFFB3D33C),
                            fontSize: 32,
                            fontWeight: FontWeight.bold,
                            letterSpacing: 2.0,
                          ),
                        ),
                        const SizedBox(height: 30),
                        const CircularProgressIndicator(
                          valueColor: AlwaysStoppedAnimation<Color>(Color(0xFF0F766E)),
                        ),
                      ],
                    ),
                  ),
                ),

              // Offline/No Internet Screen
              if (isNoInternet)
                Container(
                  color: const Color(0xFF0F1114),
                  width: double.infinity,
                  height: double.infinity,
                  padding: const EdgeInsets.symmetric(horizontal: 24),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      const Icon(
                        Icons.wifi_off_rounded,
                        size: 80,
                        color: Color(0xFFB3D33C),
                      ),
                      const SizedBox(height: 24),
                      const Text(
                        "No Internet Connection",
                        style: TextStyle(
                          fontSize: 22,
                          fontWeight: FontWeight.bold,
                          color: Colors.white,
                        ),
                      ),
                      const SizedBox(height: 12),
                      const Text(
                        "Please check your cellular or Wi-Fi network and try again.",
                        textAlign: TextAlign.center,
                        style: TextStyle(
                          fontSize: 14,
                          color: Colors.white70,
                        ),
                      ),
                      const SizedBox(height: 32),
                      ElevatedButton.icon(
                        onPressed: () {
                          setState(() {
                            isNoInternet = false;
                            isLoading = true;
                          });
                          webViewController?.reload();
                        },
                        icon: const Icon(Icons.refresh_rounded, color: Colors.black),
                        label: const Text(
                          "Retry Connection",
                          style: TextStyle(
                            color: Colors.black,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFFB3D33C),
                          padding: const EdgeInsets.symmetric(
                            horizontal: 28,
                            vertical: 14,
                          ),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(30),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
            ],
          ),
        ),
      ),
    );
  }

  void _showToast(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(message),
        duration: const Duration(seconds: 2),
        backgroundColor: const Color(0xFF0F766E),
      ),
    );
  }

  void _showExitConfirmation() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text("Exit App"),
        content: const Text("Are you sure you want to exit the application?"),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(),
            child: const Text("Cancel", style: TextStyle(color: Colors.white70)),
          ),
          ElevatedButton(
            onPressed: () {
              SystemNavigator.pop();
            },
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color(0xFF0F766E),
            ),
            child: const Text("Exit", style: TextStyle(color: Colors.white)),
          ),
        ],
      ),
    );
  }
}
