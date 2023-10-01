@include('layouts.layout')

<div class="container">
    <div class="row">
        <div class="offset-4 col-4 p-3 border border-secondary rounded">
            <form  method="POST" action="{{ url('/newPatient') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{ old('email') }}">
                    @error('email')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                <div class="mb-3" method="POST" action="{{ url('/newPatient') }}">
                    <label for="phoneNumber" class="form-label">Phone number</label>
                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}">
                    @error('phoneNumber')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="documentPhoto" class="form-label">Document photo</label>
                    <input class="form-control" type="file" id="documentPhoto" name="documentPhoto">
                    @error('documentPhoto')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-end">
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </div>
            </form>
        </div>

        @if(Session::has('message'))
            <script>
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": false,
                    "positionClass": "toast-bottom-center",
                    "timeOut": "5000",
                };
                toastr.success("{{Session::get('message')}}");
            </script>
        @endif

        @if ($errors->any())
            <script>
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": false,
                    "positionClass": "toast-bottom-center",
                    "timeOut": "10000",
                };
                toastr.error("There was an error creating the patient. Please check the form.");
            </script>
        @endif

    </div>
</div>
