<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Brand

        </h2>
    </x-slot>

    <div class="py-12">
        <div class='container'>
            <div class="row">

                <div class='col-md-8'>
                    <div class='card'>
                        
                @if (session('success'))   
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{session('success')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                        <div class='card card-header'>
                            All Brand
                        </div>

                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Nomor</th>
                                <th scope="col">Brand Name</th>
                                <th scope="col">Brand Image</th>
                                <th scope="col">created at</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>

                                @foreach ($brands as $brand )
                                <tr>
                                    <th scope='row'> {{$brands->firstItem() + $loop->index}}</th>
                                    <td> {{$brand->brand_name}}</td>
                                    <td><img src="{{asset($brand->brand_image)}}" alt="{{$brand->brand_name}}" style='width:80px;height:60px;'></td>
                                    <td>{{$brand->created_at->diffForHumans()}}</td>
                                    <td> <a href="{{url('brand/edit/'.$brand->id)}}" class='btn btn-info'>Edit </a>
                                         <a href="{{url('brand/delete/'.$brand->id)}} " onclick="return confirm('are you sure to delete ?')" class='btn btn-danger'>Hapus </a>
                                        
                                    </td>

                                </tr>   
                                    
                                @endforeach
                              
                            </tbody>
                          </table>

                          {{$brands->links()}}

                     </div>
                </div>

                <div class='col-md-4'>
                    <div class='card'>
                        <div class='card card-header'>
                            Add Categories
                        </div>

                        <div class='card card-body'>

                            <form action="{{route('store.brand')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                  <label for="addCategory">Brand Name</label>
                                  <input type="text" class="form-control"  name="brand_name" >
                                  @error('brand_name')
                                     <span class='text-danger'> {{$message}} </span>
                                  @enderror
                                </div>         
                                <div class="form-group">
                                    <label for="addCategory">Brand Image</label>
                                    <input type="file" class="form-control"  name="brand_image" >
                                    @error('brand_image')
                                       <span class='text-danger'> {{$message}} </span>
                                    @enderror
                                  </div>                                
                                <button type="submit" class="btn btn-primary">Add Brand</button>
                              </form>


                        </div> 
                        
                    </div>
                </div>


            </div>
         
        </div>
    </div>
</x-app-layout>
