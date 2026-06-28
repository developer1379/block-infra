# BLOC INFRA WebView Application

A high-performance, responsive native wrapper for the BLOC INFRA portal, built using the Flutter SDK.

---

## 🌟 Key Features

* **Full-Screen WebView Container:** Leverages the robust `flutter_inappwebview` package for native performance.
* **Persistent Sessions & Cookies:** Keeps users logged in across application exits, working seamlessly with our modified `.env` cookie settings.
* **Pull to Refresh:** Standard swipe-down gesture to refresh the current web page.
* **Smart Back Navigation:** Automatically intercepts Android physical back button presses to navigate back inside the web history instead of exiting the app.
* **Camera, Microphone, and Photo Library Support:** Configured for native file upload/capture dialogs (necessary for site reports, profile photos, and document uploads).
* **Cleartext Traffic Enabled:** Explicitly configured to allow local network HTTP development links (e.g. `http://192.168.1.100:8000`) for testing without SSL.

---

## 🚀 Getting Started

### 1. Configuration
Open `lib/main.dart` and locate the configuration block at the top:
```dart
const String defaultAppUrl = "https://blocinfra.com";
```
* **Local Testing:** Change this to your local server's IP address (e.g., `"http://192.168.1.x:8000"`). Make sure your mobile device and computer are on the same Wi-Fi network.
* **Production:** Keep it set to `"https://blocinfra.com"`.

### 2. Run the App in Development

Run the app on a connected emulator or physical device:
```bash
flutter run
```

### 3. Build for Production

#### Android (APK)
Generate a release-ready APK package:
```bash
flutter build apk --release
```
The output file will be saved at:
`build/app/outputs/flutter-apk/app-release.apk`

#### iOS (IPA)
Prepare the project for archiving in Xcode:
```bash
flutter build ipa
```
Open `ios/Runner.xcworkspace` in Xcode to configure your certificates and archive/distribute the app.
