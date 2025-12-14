<!-- Featured Properties Section -->
<section id="featured-properties" class="featured-properties section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Featured Properties</h2>
        <p>Discover our handpicked selection of premium properties in prime locations across Kenya</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        @if($featuredProperties->isNotEmpty())
            @php
                $mainProperty = $featuredProperties->shift();
                $miniProperties = $featuredProperties->take(3);
                $stackProperties = $featuredProperties->slice(3);
            @endphp

            <div class="grid-featured" data-aos="zoom-in" data-aos-delay="150">
                <!-- Main Featured Property -->
                <article class="highlight-card">
                    <div class="media">
                        <div class="badge-set">
                            <span class="flag featured">Featured</span>
                            @if($mainProperty->is_featured)
                                <span class="flag premium">Premium</span>
                            @endif
                        </div>
                        <a href="{{ route('properties.show', $mainProperty->slug) }}" class="image-link">
                            @if($mainProperty->featured_image)
                                <img src="{{ asset('storage/' . $mainProperty->featured_image) }}" alt="{{ $mainProperty->title }}" class="img-fluid">
                            @else
                                <img src="{{ asset('assets/img/real-estate/property-placeholder.jpg') }}" alt="{{ $mainProperty->title }}" class="img-fluid">
                            @endif
                        </a>
                        <div class="quick-specs">
                            @if($mainProperty->bedrooms)
                                <span><i class="bi bi-door-open"></i> {{ $mainProperty->bedrooms }} {{ $mainProperty->bedrooms == 1 ? 'Bed' : 'Beds' }}</span>
                            @endif
                            @if($mainProperty->bathrooms)
                                <span><i class="bi bi-droplet"></i> {{ $mainProperty->bathrooms }} {{ $mainProperty->bathrooms == 1 ? 'Bath' : 'Baths' }}</span>
                            @endif
                            @if($mainProperty->size)
                                <span><i class="bi bi-aspect-ratio"></i> {{ number_format($mainProperty->size) }} {{ $mainProperty->size_unit ?? 'sq ft' }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="content">
                        <div class="top">
                            <div>
                                <h3><a href="{{ route('properties.show', $mainProperty->slug) }}">{{ $mainProperty->title }}</a></h3>
                                <div class="loc">
                                    <i class="bi bi-geo-alt-fill"></i> 
                                    {{ $mainProperty->county->name ?? '' }}{{ $mainProperty->sub_county ? ', ' . $mainProperty->sub_county : '' }}
                                </div>
                            </div>
                            <div class="price">
                                @if($mainProperty->discounted_price && $mainProperty->discounted_price < $mainProperty->price)
                                    <span class="text-muted text-decoration-line-through me-2">KES {{ number_format($mainProperty->price) }}</span>
                                    <span>KES {{ number_format($mainProperty->discounted_price) }}</span>
                                @else
                                    KES {{ number_format($mainProperty->price) }}
                                @endif
                            </div>
                        </div>
                        <p class="excerpt">{{ Str::limit(strip_tags($mainProperty->description), 120) }}</p>
                        <div class="cta">
                            <a href="{{ route('properties.show', $mainProperty->slug) }}" class="btn-main">View Details</a>
                            <a href="{{ route('contact') }}" class="btn-soft">Arrange Visit</a>
                            <div class="meta">
                                <span class="status {{ $mainProperty->status === 'for_sale' ? 'for-sale' : 'for-rent' }}">
                                    {{ str_replace('_', ' ', ucfirst($mainProperty->status)) }}
                                </span>
                                <span class="listed">Listed {{ $mainProperty->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </article><!-- End Highlight Card -->

                <!-- Mini Properties -->
                <div class="mini-list">
                    @foreach($miniProperties as $index => $property)
                        <article class="mini-card" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 50) }}">
                            <a href="{{ route('properties.show', $property->slug) }}" class="thumb">
                                @if($property->featured_image)
                                    <img src="{{ asset('storage/' . $property->featured_image) }}" alt="{{ $property->title }}" class="img-fluid" loading="lazy">
                                @else
                                    <img src="{{ asset('assets/img/real-estate/property-placeholder.jpg') }}" alt="{{ $property->title }}" class="img-fluid" loading="lazy">
                                @endif
                                @if($property->is_featured)
                                    <span class="label featured"><i class="bi bi-star-fill"></i> Featured</span>
                                @elseif($property->created_at->diffInDays(now()) < 7)
                                    <span class="label new"><i class="bi bi-star-fill"></i> New</span>
                                @endif
                            </a>
                            <div class="mini-body">
                                <h4><a href="{{ route('properties.show', $property->slug) }}">{{ Str::limit($property->title, 30) }}</a></h4>
                                <div class="mini-loc">
                                    <i class="bi bi-geo"></i> {{ $property->county->name ?? 'Nairobi' }}{{ $property->sub_county ? ', ' . $property->sub_county : '' }}
                                </div>
                                <div class="mini-specs">
                                    @if($property->bedrooms)
                                        <span><i class="bi bi-door-open"></i> {{ $property->bedrooms }}</span>
                                    @endif
                                    @if($property->bathrooms)
                                        <span><i class="bi bi-droplet"></i> {{ $property->bathrooms }}</span>
                                    @endif
                                    @if($property->size)
                                        <span><i class="bi bi-rulers"></i> {{ number_format($property->size) }} {{ $property->size_unit ?? 'sq ft' }}</span>
                                    @endif
                                </div>
                                <div class="mini-foot">
                                    <div class="mini-price">
                                        KES {{ number_format($property->discounted_price && $property->discounted_price < $property->price ? $property->discounted_price : $property->price) }}
                                    </div>
                                    <a href="{{ route('properties.show', $property->slug) }}" class="mini-btn">Details</a>
                                </div>
                            </div>
                        </article><!-- End Mini Card -->
                    @endforeach
                </div><!-- End Mini List -->
            </div>

            <!-- Stack Cards -->
            @if($stackProperties->isNotEmpty())
                <div class="row gy-4 mt-4">
                    @foreach($stackProperties as $index => $property)
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ 300 + ($index * 50) }}">
                            <article class="stack-card">
                                <figure class="stack-media">
                                    @if($property->featured_image)
                                        <img src="{{ asset('storage/' . $property->featured_image) }}" alt="{{ $property->title }}" class="img-fluid" loading="lazy">
                                    @else
                                        <img src="{{ asset('assets/img/real-estate/property-placeholder.jpg') }}" alt="{{ $property->title }}" class="img-fluid" loading="lazy">
                                    @endif
                                    <figcaption>
                                        @if($property->is_featured)
                                            <span class="chip exclusive">Featured</span>
                                        @elseif($property->created_at->diffInDays(now()) < 7)
                                            <span class="chip new">New</span>
                                        @else
                                            <span class="chip">{{ ucfirst($property->type) }}</span>
                                        @endif
                                    </figcaption>
                                </figure>
                                <div class="stack-body">
                                    <h5><a href="{{ route('properties.show', $property->slug) }}">{{ Str::limit($property->title, 35) }}</a></h5>
                                    <div class="stack-loc">
                                        <i class="bi bi-geo-alt"></i> {{ $property->county->name ?? 'Nairobi' }}{{ $property->sub_county ? ', ' . $property->sub_county : '' }}
                                    </div>
                                    <ul class="stack-specs">
                                        @if($property->bedrooms)
                                            <li><i class="bi bi-door-open"></i> {{ $property->bedrooms }}</li>
                                        @endif
                                        @if($property->bathrooms)
                                            <li><i class="bi bi-droplet"></i> {{ $property->bathrooms }}</li>
                                        @endif
                                        @if($property->size)
                                            <li><i class="bi bi-aspect-ratio"></i> {{ number_format($property->size) }} {{ $property->size_unit ?? 'sq ft' }}</li>
                                        @endif
                                    </ul>
                                    <div class="stack-foot">
                                        <span class="stack-price">
                                            KES {{ number_format($property->discounted_price && $property->discounted_price < $property->price ? $property->discounted_price : $property->price) }}
                                            @if($property->discounted_price && $property->discounted_price < $property->price)
                                                <small class="text-muted text-decoration-line-through">KES {{ number_format($property->price) }}</small>
                                            @endif
                                        </span>
                                        <a href="{{ route('properties.show', $property->slug) }}" class="stack-link">View</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i> No featured properties available at the moment. Please check back later.
                </div>
            </div>
        @endif
    </div>
</section><!-- /Featured Properties Section -->
