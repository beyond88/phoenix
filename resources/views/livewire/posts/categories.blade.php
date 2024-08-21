<div>
   <form class="mb-9">
      <div class="row g-3 flex-between-end mb-5">
         <div class="col-auto">
            <h2 class="mb-2">Categories</h2>
            <h5 class="text-body-tertiary fw-semibold">Create post categories across your store</h5>
         </div>
         <div class="col-auto">
            <button class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button" wire:click.prevent="cancelCat()">Discard</button>
            @if ($updateCat)
                <button class="btn btn-primary mb-2 mb-sm-0" type="button" wire:click.prevent="updateCat()">Update</button>
            @else
                <button class="btn btn-primary mb-2 mb-sm-0" type="button" wire:click.prevent="storeCat()">Save</button>
            @endif
         </div>
      </div>
      <div class="row g-5">
         <div class="col-12 col-xl-8">
            <h4 class="mb-3">Name</h4>
            <input class="form-control mb-5 @error('name') is-invalid @enderror" type="text" placeholder="" wire:model="name" />
            <h4 class="mb-3">Slug</h4>
            <input class="form-control mb-5 @error('slug') is-invalid @enderror" type="text" placeholder="" wire:model="slug" />
         </div>
         <div class="col-12 col-xl-4">
            <div class="row g-2">
               <div class="col-12 col-xl-12">
                  <div class="card mb-3">
                     <div class="card-body">
                        <h4 class="card-title mb-4">Categories</h4>
                        <div class="row gx-3">
                           <div class="col-12 col-sm-6 col-xl-12">
                              <div class="mb-4">
                                 <table class="table">
                                    <thead>
                                       <tr>
                                          <th scope="col">Name</th>
                                          <th scope="col">Slug</th>
                                          <th scope="col">Count</th>
                                          <th scope="col">Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @if (count($cats) > 0)
                                            @foreach($cats as $cat)
                                                <tr>
                                                    <td>
                                                        {{$cat->name}}
                                                    </td>
                                                    <td>
                                                        {{$cat->slug}}
                                                    </td>
                                                    <td>
                                                        0
                                                    </td>
                                                    <td>
                                                        <button wire:click="editCat({{$cat->term_id}})" class="btn btn-primary me-1 mb-1" type="button">Edit</button>
                                                        <button wire:click="deleteCat({{$cat->term_id}})"class="btn btn-danger me-1 mb-1" type="button">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">
                                                    No Categories Found.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </form>
</div>