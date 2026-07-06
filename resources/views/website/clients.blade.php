<x-website-layout 
    title="Our Clients & Partners | Bloc-Infra Portfolio" 
    description="See how we collaborate with top developers, public organizations, and private clients to deliver successful construction projects in Kanpur." 
    keywords="construction clients, project portfolio, client reviews, partner companies"
>

    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-5 text-uppercase fw-bold" style="color:#b3d33c;">Our Clients</h1>
        <p class="text-white-50">Trusted by leading brands and organizations across industries.</p>
    </div>

    <div class="container py-5">
        <div class="row g-4 text-center">
            @foreach (['L&T Construction', 'DMR Infra Build', 'UP Housing Board', 'Smart City Kanpur', 'PWD Projects', 'Metro Railworks'] as $client)
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.{{ $loop->index + 2 }}s">
                    <div class="p-4 border rounded shadow-sm bg-light">
                        <i class="bi bi-building fs-1 mb-3" style="color:#b3d33c;"></i>
                        <h5 class="fw-bold text-dark">{{ $client }}</h5>
                        <p class="text-dark small">Delivering excellence through partnership and precision.</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-website-layout>

