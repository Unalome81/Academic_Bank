<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Academic Bank of Credit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class='bg-dark' style="padding: 20px 0;">
      <h1 class="text-white text-center">Academic Bank of Credit</h1>
    </div>

    <div class="container mt-5">
      <div class="row justify-content-center mt-4">
          <div class="col-md-10 d-flex justify-content-end">
              <a href="{{ route('products.index') }}" class="btn btn-dark">Back</a>
          </div>
      </div>
      <div class="row d-flex justify-content-center">
        <div class="col-md-10">
          <div class="card border-0 shadow-lg my-4">
            <div class="card-header bg-dark">
              <h3 class="text-white">Edit Institution Details</h3>
            </div>
            <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                  @if (session('success'))
                      <div class="alert alert-success">
                          {{ session('success') }}
                      </div>
                  @endif
                  <div class="mb-3">
                    <label for="institution-name" class="form-label h4">Name</label>
                    <input value="{{ old('name', $product->name) }}" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="institution-name" placeholder="Name" name="name">
                    @error('name')
                      <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="description" class="form-label h4">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" cols="30" rows="5">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                      <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="logo" class="form-label h4">Logo</label>
                    <input type="file" class="form-control form-control-lg @error('image') is-invalid @enderror" id="logo" name="image">
                    @if($product->image)
                        <img class="w-50 my-3" src="{{ asset('uploads/products/' . $product->image) }}" alt="">
                    @endif
                    @error('image')
                      <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                  </div>

                  <div class="d-grid">
                    <button class="btn btn-lg btn-primary">Submit</button>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
