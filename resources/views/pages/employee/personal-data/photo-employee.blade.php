 <section class="section">
   <div class="row">
     <div class="col-12">
       <div class="card">
         <div class="card-header">
           <h5 class="card-title">Photo Karyawan</h5>

           @if (!$employee->is_verified)
             <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
               data-bs-target="#modal-form-add-employee-photo">
               <i class="bi bi-plus-lg"></i>
               Add
             </button>
             @include('pages.employee.personal-data.form.employee-photo.modal-create')
           @endif
         </div>
         <div class="card-body">
           <div class="row gallery">

             @forelse ($employee->employeePhotos as $employeePhoto)
               <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2 text-center position-relative">
                 <hr>
                 <a href="{{ asset($employeePhoto->file_path ? 'storage/' . $employeePhoto->file_path : 'storage/img/2.jpg') }}"
                   data-fancybox>
                   <img class="w-100 active mb-2" alt="img"
                     src="{{ asset($employeePhoto->file_path ? 'storage/' . $employeePhoto->file_path : 'storage/img/2.jpg') }}">
                 </a>

                 <!-- Action Buttons -->
                 <div class="d-flex justify-content-around mb-4">
                   <!-- Set as Main Photo Button -->
                   @if (!$employeePhoto->main_photo)
                     <form method="POST" action="{{ route('employeePhoto.update', $employeePhoto->id) }} ">
                       @csrf
                       @method('put')
                       <button type="submit" class="btn btn-success btn-sm"
                         onclick="return confirm('Are you sure you want to set this photo as main photo?');">
                         Set as Main Photo
                       </button>
                     </form>
                   @else
                     <span class="text-success small">Main Photo</span>
                   @endif


                   @if (!$employee->is_verified)
                     <!-- Delete Button -->
                     <form method="POST" action="{{ route('employeePhoto.destroy', $employeePhoto->id) }}">
                       @csrf
                       @method('DELETE')
                       <button type="submit" class="btn btn-danger btn-sm"
                         onclick="return confirm('Are you sure you want to delete this photo?');">
                         Delete
                       </button>
                     </form>
                   @endif

                 </div>
               </div>
             @empty
               <p>No photos available.</p>
             @endforelse



           </div>

           {{-- <div class="row mt-2 mt-md-4 gallery" data-bs-toggle="modal" data-bs-target="#galleryModal">
             <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
               <a href="#">
                 <img class="w-100 active"
                   src="https://images.unsplash.com/photo-1633008808000-ce86bff6c1ed?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyN3x8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                   data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
               </a>
             </div>
             <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
               <a href="#">
                 <img class="w-100"
                   src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?ixid=MnwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=870&q=80"
                   data-bs-target="#Gallerycarousel" data-bs-slide-to="1">
               </a>
             </div>
             <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
               <a href="#">
                 <img class="w-100"
                   src="https://images.unsplash.com/photo-1632951634308-d7889939c125?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0M3x8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                   data-bs-target="#Gallerycarousel" data-bs-slide-to="2">
               </a>
             </div>
             <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
               <a href="#">
                 <img class="w-100"
                   src="https://images.unsplash.com/photo-1632949107130-fc0d4f747b26?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3OHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                   data-bs-target="#Gallerycarousel" data-bs-slide-to="3">
               </a>
             </div>
           </div> --}}

         </div>
       </div>
     </div>
   </div>
 </section>
