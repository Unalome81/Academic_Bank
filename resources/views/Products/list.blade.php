<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Academic Bank of Credit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class='bg-dark' style="padding: 50px 0;">
      <h1 class="text-white text-center">Academic Bank of Credit</h1>
    </div>

    <div class="container mt-5">
      <div class="row justify-content-center mt-4">
        <div class="col-md-10 d-flex justify-content-end">
            <a href="{{ route('products.create') }}" class="btn btn-dark">Create</a>
        </div>
      </div>

      <div class="row d-flex justify-content-center">
        @if (Session::has('success'))
            <div class="col-md-10"> 
                <div class="alert alert-success"> 
                    {{ Session::get('success') }}
                </div>
            </div>
        @endif
        <div class="col-md-10">
          <div class="card border-0 shadow-lg my-4">
            <div class="card-header bg-dark">
              <h3 class="text-white">View Institutions</h3>
            </div>

            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Institute Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>

                    @if($products->isNotEmpty())
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image != "")
                                    <img width="50" src="{{ asset('uploads/products/' . $product->image) }}" alt="">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-dark">Edit</a>
                                <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-product-{{ $product->id }}').submit();" class="btn btn-danger">Delete</a>
                                <form id="delete-product-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="post" style="display: none;">
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                        </tr> 
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No products found</td>
                        </tr>
                    @endif
                </table>
            </div>

          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
