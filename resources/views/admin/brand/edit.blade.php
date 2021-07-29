<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Edit Brand

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
                            Update Brand
                        </div>

                        <div class='card card-body'>

                            <form action="{{url('brand/update/'.$brands->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="old_image" value="{{$brands->brand_image}}">
                                <div class="form-group">
                                  <label for="addCategory">Brand Name</label>
                                  <input type="text" class="form-control"  name="brand_name" value='{{$brands->brand_name}}' >
                                  @error('brand_name')
                                     <span class='text-danger'> {{$message}} </span>
                                  @enderror
                                </div>         
                                <div class="form-group">
                                    <label for="addCategory">Brand Image</label>
                                    <input type="file" class="form-control"  name="brand_image" value='{{$brands->brand_image}}' >
                                    @error('brand_image')
                                       <span class='text-danger'> {{$message}} </span>
                                    @enderror
                                  </div>            
                                  
                                <div class='form-group'>
                                    <img src='{{asset($brands->brand_image)}}' alt='{{$brands->brand_name}}' >

                                </div>   
                                <button type="submit" class="btn btn-primary">update Brand</button>
                              </form>


                        </div> 
                        
                    </div>
                </div>


            </div>
         
        </div>
    </div>
</x-app-layout>
