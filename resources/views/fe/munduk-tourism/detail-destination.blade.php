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
                                    <img src="{{ asset($destination->thumbnail) }}" class="d-block w-100" alt="thumbnail" style="width: 400px; height: 400px; object-fit: cover">
                                </div>
                                @foreach ($destination->images as $image)
                                    <div class="carousel-item ">
                                        <img src="{{ asset($image->url) }}" class="d-block w-100" alt="{{ $image->title }}" style="width: 400px; height: 400px; object-fit: cover">
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
                <!-- Destination Details -->
                <div class="col-md-4 ftco-animate fadeInUp ftco-animated">
                    <div class="destination-details">
                        <h3 class="mb-4">{{ $destination->name }}</h3>
                    </div>
                    <div class="destination-details">
                        <div class="availability" style="color: black">
                            <p>
                                Manager : {{ $destination->user->name }}
                            </p>
                            <p>
                                Destination Category:  @foreach ($destination->categories as $category)
                                      {{ $category->name }}
                                        @if (!$loop->last)
                                            ,
                                        @endif

                                    @endforeach
                                </span>
                            </p>
                            <p>
                                Phone Number : {{ $destination->user->phone }}
                            </p>

                            <p class="location">Address : {{ $destination->address }}</p>
                        </div>

                    </div>
                </div>
                <div class="description text-justify p-4" style="color: black; !important">
                    <h3 class="mb-4">{{ $destination->name }}</h3>
                    <p>{!! $destination->description !!}</p>
                </div>
            </div>
            <div>
                <p class="font-size:20px"><b>Share this</b></p>
                 <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                    <li class="ftco-animate fadeInUp ftco-animated"><a href="https://www.facebook.com/sharer.php?u=https://munduktourism.com/destination/gubug-tamblingan-temple" target="_blank"><span class="fa fa-facebook"></span></a></li>
                    <li class="ftco-animate fadeInUp ftco-animated"><a href="https://api.whatsapp.com/send?text=https://munduktourism.com/destination/gubug-tamblingan-temple" target="_blank"><span class="fa fa-whatsapp"></span></a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection

