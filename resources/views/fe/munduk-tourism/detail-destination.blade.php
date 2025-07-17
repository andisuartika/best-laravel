@extends('fe.munduk-tourism.layout')

@section('content')
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate fadeInUp ftco-animated">
                <span class="subheading">Munduk Tourism</span>
                <h2 class="mb-4">Destination Detail</h2>
            </div>
        </div>

        <div class="row">
            <!-- Destination Image Slider -->
            <div class="col-md-8 ftco-animate fadeInUp ftco-animated">
                <div id="destination-slider" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset($destination->thumbnail) }}" class="d-block w-100" alt="thumbnail" style="width: 100%; height: 400px; object-fit: cover">
                        </div>
                        @foreach ($destination->images as $image)
                        <div class="carousel-item">
                            <img src="{{ asset($image->url) }}" class="d-block w-100" alt="{{ $image->title }}" style="width: 100%; height: 400px; object-fit: cover">
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#destination-slider" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#destination-slider" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <!-- Booking Card -->
            <div class="col-md-4 ftco-animate fadeInUp ftco-animated">
                <div class="card p-4 shadow-sm" style="border-radius: 12px;">
                    <h4 class="font-weight-bold mb-3">Booking Ticket</h4>

                    <div class="form-group">
                        <label for="date" class="font-weight-bold">Date</label>
                        <input type="date" class="form-control" id="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>

                    <hr>

                    <p class="font-weight-bold">Available Ticket(s) for You:</p>

                   @foreach ($destination->prices as $price)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="font-weight-bold">{{ $price->name }}</div>
                            <small class="text-muted">@currency($price->price)</small>
                        </div>
                        <div class="input-group" style="width: 100px;">
                            <div class="input-group-prepend">
                                <button
                                    class="btn btn-outline-secondary btn-sm"
                                    onclick="changeQty('{{ $price->code }}', -1)"
                                >−</button>
                            </div>
                            <input
                                type="text"
                                class="form-control text-center"
                                id="qty-{{ $price->code }}"
                                value="0"
                                readonly
                                data-price="{{ $price->price }}"
                                data-code="{{ $price->code }}"
                            >
                            <div class="input-group-append">
                                <button
                                    class="btn btn-outline-secondary btn-sm"
                                    onclick="changeQty('{{ $price->code }}', 1)"
                                >+</button>
                            </div>
                        </div>
                    </div>
                    @endforeach



                    <div class="d-flex justify-content-between font-weight-bold h5 mb-3">
                        <div>Total:</div>
                        <div id="total">Rp 0</div>
                    </div>

                   <button class="btn btn-primary btn-block rounded-pill" onclick="submitBooking()">Book Now &rarr;</button>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="row mt-5">
            <div class="col-12 description text-justify p-4" style="color: black;">
                <h3 class="mb-4">{{ $destination->name }}</h3>
                <p>{!! $destination->description !!}</p>
            </div>
        </div>

        <!-- Share -->
        <div class="mt-4">
            <p style="font-size: 20px"><b>Share this</b></p>
            <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                <li class="ftco-animate fadeInUp ftco-animated">
                    <a href="https://www.facebook.com/sharer.php?u={{ url()->current() }}" target="_blank"><span class="fa fa-facebook"></span></a>
                </li>
                <li class="ftco-animate fadeInUp ftco-animated">
                    <a href="https://api.whatsapp.com/send?text={{ url()->current() }}" target="_blank"><span class="fa fa-whatsapp"></span></a>
                </li>
            </ul>
        </div>
    </div>
</section>

<script>
    function changeQty(code, delta) {
        let input = document.getElementById('qty-' + code);
        let current = parseInt(input.value);
        current = Math.max(0, current + delta);
        input.value = current;
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('input[id^="qty-"]').forEach(function(input) {
            let qty = parseInt(input.value);
            let price = parseInt(input.getAttribute('data-price'));
            total += qty * price;
        });
        document.getElementById("total").textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function submitBooking() {
        const baseUrl = 'https://bestdesta.web.id/booking/destination';
        const slug = '{{ $destination->slug }}';
        const type = 'destination';
        const date = document.getElementById('date').value;

        const ticketTypes = [];
        const quantities = [];

        document.querySelectorAll('input[id^="qty-"]').forEach(function(input) {
            const qty = parseInt(input.value);
            if (qty > 0) {
                const code = input.getAttribute('data-code');
                ticketTypes.push(code);
                quantities.push(qty);
            }
        });

        if (ticketTypes.length === 0) {
            alert('Please select at least one ticket.');
            return;
        }

        const params = new URLSearchParams();
        params.append('type', type);
        params.append('slug', slug);
        params.append('date', date);
        ticketTypes.forEach((code, index) => {
            params.append('ticket_type[]', code);
            params.append('quantity[]', quantities[index]);
        });

        const fullUrl = `${baseUrl}?${params.toString()}`;
        window.open(fullUrl, '_blank'); // ✅ Buka tab baru;
    }
</script>


@endsection
