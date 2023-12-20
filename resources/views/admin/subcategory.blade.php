@extends('layouts.admin_master')
@section('admin_main_content')
<div class="row">

    <div class="col-lg-8">
        <div class="card-style mb-30">
            <div class="card">
                <h5 class="card-header">Sub Category List</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Subcategory Name</th>
                        <th>Category Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @forelse ($subcategories as $key=> $subcategory)
                      <tr>
                        <td>{{ $subcategory->name }}</td>
                        <td>{{ $subcategory->category->name }}</td>
                        <td>
                            <div class="form-check form-switch toggle-switch">
                                <input class="form-check-input change_status" type="checkbox" id="toggleSwitch2" {{ $subcategory->status  ? "checked":"" }} data-subcategory-id="{{ $subcategory->id }}">
                              </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.subcategory.edit',$subcategory->id ) }}" class="btn btn-sm btn-info btn-hober">
                                <i class='bx bxs-edit-alt'></i>
                            </a>

                            <button class="btn btn-sm btn-danger btn-hober delete_btn">
                                <i class='bx bx-trash'></i>
                            </button>
                            <form action="{{ route('admin.subcategory.delete',$subcategory->id ) }}" method="POST">
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>
                    </tr>
                      @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger">
                                <strong>No data found!</strong>
                            </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ isset($editData) ? 'Update' :'Add New' }} sub Category</h5> <small class="text-muted float-end"></small>
          </div>
          <div class="card-body">
            <form action="{{ isset($editData) ? route('admin.subcategory.update', $editData->id) : route('admin.subcategory.store') }}" method="POST" enctype="multipart/form-data">
                @isset($editData)
                    @method('PUT')
                @endisset
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">category</label>
                    <div class="select-position">
                      <select class="form-control" name="category">
                        <option>Select category</option>
                        @forelse ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @empty
                        <option>No category found!</option>
                        @endforelse
                      </select>
                      @error('category')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    </div>
                  </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">sub Category Name</label>
                <input type="text" class="form-control" id="basic-default-fullname" name="name" value="{{ isset($editData) ? $editData->name :'' }}"/>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              </div>
              <button type="submit" class="btn btn-primary w-100">{{ isset($editData) ? 'Update' :'Add New' }} sub Category</button>
            </form>
          </div>
        </div>
      </div>
</div>
@endsection
@push('additional_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
         });

    $('.delete_btn').on('click', function(){
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
           $(this).next('form').submit();
        }
        });
    })

        $('.change_status').on('change', function(){
            $.ajax({
                url: "{{ route('admin.subcategory.change_status') }}",
                method: "GET",
                data:{
                    subcategory_id: $(this).data('subcategory-id')
                },
                success:function(res){
                    Toast.fire({
                        icon: "success",
                        title: "Status change successfully"
                    });
                }
            })
        })

</script>
@endpush
