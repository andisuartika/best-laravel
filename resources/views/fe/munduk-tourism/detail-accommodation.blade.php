@extends('fe.munduk-tourism.layout')
@section('content')
  <!-- Daterangepicker CSS -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"
  />
  <style>
    .block-27 ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: inline-block;
    }
    .block-27 li {
      display: inline-block;
      margin: 0 5px;
    }
    .block-27 li a,
    .block-27 li span {
      display: block;
      padding: 8px 12px;
      color: #555;
      text-decoration: none;
    }
    .block-27 li.active span {
      background: #007bff;
      color: #fff;
      border-radius: 4px;
    }
    .block-27 li.disabled span {
      color: #ccc;
    }
     .collapse-toggle {
    cursor: pointer;
    }
    .fee-box {
        background: #eef7f7;
        padding: 1rem;
        border-radius: .25rem;
    }
      .remove-item {
    cursor: pointer;
    }
    .remove-item:hover {
        text-decoration: underline; /* opsional, biar terlihat lebih interaktif */
    }
  </style>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate fadeInUp ftco-animated">
                    <span class="subheading">Munduk Tourism</span>
                    <h2 class="mb-4">Select Room</h2>
                </div>
            </div>
        </div>
        <div class="container my-4">

        <!-- HEADER: Date picker & guests -->
        <div class="border rounded p-3 mb-5 d-flex flex-wrap align-items-center">
            <div class="mr-3 flex-fill" style="min-width: 250px;">
            <label class="font-weight-bold">Select dates</label>
            <input type="text" id="daterange" class="form-control" />
            </div>
            <div class="mr-3" style="min-width: 200px;">
            <label class="font-weight-bold">Guests</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" id="guest-decrement" type="button">−</button>
                    </div>
                    <input type="text"
                        id="guest-count"
                        class="form-control text-center"
                        value="2"
                        readonly>
                    <div class="input-group-append">
                    <button class="btn btn-outline-secondary" id="guest-increment" type="button">+</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="row">
            <!-- LEFT: Room cards -->
            <div class="col-md-8">
                <div id="rooms-list">
                    <!-- Room Card Template -->
                    @foreach ($accommodation->roomTypes as  $item )
                    <div class="card mb-4 room-card" data-name="{{ $item->name }}" data-price="{{ $item->rates->first()->price }}"  data-room-code="{{ $item->code }}">>
                        <div class="row no-gutters">
                             <div class="col-md-4 d-flex">
                            <img src="{{ asset($item->thumbnail) }}"
                                class="card-img h-100 w-100"
                                style="object-fit: cover;"
                                alt="Room">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text small text-muted">
                                    @php

                                    $facilities = json_decode($item->facilities, true);
                                    @endphp
                                 @foreach($facilities as $facility)
                                    &middot; {{ $facility }}
                                @endforeach
                                </p>
                                <p class="card-text"><strong>@currency( $item->rates->first()->price)</strong><br><small>Cost for 1 night, 2 guests</small></p>
                                <button class="btn btn-primary btn-select-room">Select</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- /Room Card -->

                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body" id="booking-detail">
                    <!-- Content akan dirender lewat JS -->
                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
    $(function(){
        // State
        let bookingItems = [];
        const FEE_RATE = 0.15;
        let nights = 1; // default

        // DateRangePicker
        $('#daterange').daterangepicker({
            opens: 'left',
            locale: { format: 'D MMM YYYY' },
            startDate: moment(),
            endDate: moment().add(1,'days'),
            minDate: moment()
        }, function(start,end){
            nights = end.diff(start,'days');
            renderDetail();
        });

        // Guest counter
        let guestCount = parseInt($('#guest-count').val(),10);
        $('#guest-increment').click(()=>{
            guestCount++;
            $('#guest-count').val(guestCount);
            renderDetail();
        });
        $('#guest-decrement').click(()=>{
            if (guestCount>1) {
            guestCount--;
            $('#guest-count').val(guestCount);
            renderDetail();
            }
        });

        // Select room
        $('.btn-select-room').click(function(){
            const card  = $(this).closest('.room-card');
            const name  = card.data('name');
            const price = +card.data('price');
            const code  = card.data('roomCode');    // ← ambil roomType code

            // cari existing dengan code
            let existing = bookingItems.find(i=> i.code === code);
            if (existing) {
                existing.qty++;
            } else {
                bookingItems.push({ name, price, code, qty: 1 });
            }
            renderDetail();
        });

        // Remove item
        $('#booking-detail').on('click','.remove-item',function(e){
            e.preventDefault();
            const name = $(this).data('name');
            bookingItems = bookingItems.filter(i=>i.name!==name);
            renderDetail();
        });

        // Render sidebar
        function renderDetail(){
            const picker = $('#daterange').data('daterangepicker');
            const start  = picker.startDate, end = picker.endDate;
            const guests = guestCount;
            if (bookingItems.length===0){
            $('#booking-detail').html(`
                <h5 class="card-title">Your Booking</h5>
                <p>No room selected yet.</p>
                <button class="btn btn-primary btn-block" disabled>Book</button>
            `);
            return;
            }
            // hitung subtotal
            let subtotal = 0;
            bookingItems.forEach(i=>{
            subtotal += i.price * i.qty * nights;
            });
            const fee  = subtotal * FEE_RATE;
            const total= subtotal + fee;

            // bangun HTML…
            let html = `
            <h5 class="card-title">IDR ${total.toLocaleString()} total</h5>
            <div class="d-flex justify-content-between text-muted">
                <small>${start.format('D MMM YY')}—${end.format('D MMM YY')}</small>
                <small>${nights} night${nights>1?'s':''}</small>
            </div>
            <div class="text-muted mb-2">
                ${bookingItems.reduce((a,b)=>a+b.qty,0)} room(s), ${guests} guest(s)
            </div><hr>
            `;
            bookingItems.forEach(i=>{
            const sub = i.price * i.qty * nights;
            html+=`
            <div class="d-flex justify-content-between">
                <div>
                <strong>${i.name}</strong><br>
                <small>${i.qty}×${nights} night(s)</small><br>
                <small class="text-danger remove-item" data-name="${i.name}">Remove</small>
                </div>
                <div><strong>IDR ${sub.toLocaleString()}</strong></div>
            </div><hr>`;
            });
            html+=`
            <div class="d-flex justify-content-between">
                <span>Subtotal</span><span>IDR ${subtotal.toLocaleString()}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Fee (15%)</span><span>IDR ${fee.toLocaleString()}</span>
            </div><hr>
            <div class="d-flex justify-content-between font-weight-bold">
                <span>Grand Total</span><span>IDR ${total.toLocaleString()}</span>
            </div>
            <button id="btn-book" class="btn btn-primary btn-block mt-3">Book</button>
            `;
            $('#booking-detail').html(html);
        }

        $('#booking-detail').on('click', '#btn-book', function() {
            const picker   = $('#daterange').data('daterangepicker');
            const checkIn  = picker.startDate.format('YYYY-MM-DD');
            const checkOut = picker.endDate.format('YYYY-MM-DD');
            const guests   = parseInt($('#guest-count').val(), 10);
            const mainCode = @json($accommodation->code);

            // 1) Bangun payload array { roomType, quantity }
            const itemsPayload = bookingItems.map(item => ({
                roomType: item.code,
                quantity: item.qty
            }));

            // 2) Siapkan URLSearchParams
            const params = new URLSearchParams({
                type:     'homestay',
                code:     mainCode,
                checkIn,
                checkOut,
                guest:    guests.toString(),
                quantity: itemsPayload.reduce((sum, i) => sum + i.quantity, 0).toString()
            });

            // 3) Tambahkan objek-objek tadi sebagai JSON-encoded param `items`
            params.set('items', JSON.stringify(itemsPayload));

            // 4) Buka di tab baru
            const url = '/booking/homestay?' + params.toString();
            window.open(url, '_blank');
        });



        // initial render
        renderDetail();
    });
    </script>

@endsection

