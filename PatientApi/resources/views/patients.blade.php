<div class="container">
    <div class="row row-cols-md-5 row-cols-3">
        @forelse ($patients as $id=>$patient)
            <div class="col">
                <div class="card">
                    @isset($patient->documentPhoto)
                        <img class="card-img-top cut-img" src="{{ asset('storage/images/'.$patient->documentPhoto)}}" alt="{{$patient->name}} document photo">
                    @else
                        <img class="card-img-top cut-img" src="{{ asset('storage/images/DocImage.png')}}" alt="{{$patient->name}} document photo">
                    @endisset
                    <h3 class="card-title">{{$patient->name}}</h3>
                    <button class="btn btn-secondary btn-card" style="" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$id}}" aria-expanded="false" aria-controls="collapse-{{$id}}">
                        Info
                    </button>
                    <div class="collapse" id="collapse-{{$id}}">
                        <div class="card-body">
                            <h6><strong>Email</strong></h6>
                            <p class="card-text">{{$patient->email}}</p>
                            <h6><strong>Phone number</strong></h6>
                            <p class="card-text">{{$patient->phoneNumber}}</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div>
                <p>No users found.</p>
            </div>
        @endforelse
    </div>
</div>

