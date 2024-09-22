    <div class="container">
        @if ($errors->any())
            <div class="pt-3">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if (session()->has('message'))
            <div class="mt-3">
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <!-- START FORM -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <form>
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" wire:model="email">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="adress" class="col-sm-2 col-form-label">Adress</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="adress">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        @if ($update_data == false)
                            <button type="button" class="btn btn-primary" name="submit"
                                wire:click="store()">SIMPAN</button>
                        @else
                            <button type="button" class="btn btn-primary" name="submit"
                                wire:click="update()">UPDATE</button>
                        @endif
                        <button type="button" class="btn btn-secondary" name="submit"
                            wire:click="clear()">CLEAR</button>
                    </div>

                </div>
            </form>
        </div>
        <!-- AKHIR FORM -->

        <!-- START DATA -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1 class="mb-2">Data Pegawai</h1>
            <div class="pb-3 pt-3">
                <input type="search" class="form-control mb-3 w-25" placeholder="Search" wire:model.live="search">
            </div>
            @if ($employee_selected_id)
                <a wire:click="delete_confirmation('')" class="btn btn-danger btn-sm"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">Del {{count($employee_selected_id)}} data</a>
            @endif

            {{ $dataemployee->links() }}
            <table class="table table-striped table-sortable">
                <thead>
                    <tr>
                        <th></th>
                        <th class="col-md-1">No</th>
                        <th class="col-md-4 sort @if ($sort_colomn=='name') {{$sort_direction}} @endif" wire:click="sort('name')">Name</th>
                        <th class="col-md-3 sort @if ($sort_colomn=='email') {{$sort_direction}} @endif" wire:click="sort('email')">Email</th>
                        <th class="col-md-2 sort @if ($sort_colomn=='adress') {{$sort_direction}} @endif" wire:click="sort('adress')">Adress</th>
                        <th class="col-md-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataemployee as $key => $data)
                        <tr>
                            <td><input type="checkbox" value="{{ $data->id }}" wire:key="{{ $data->id }}"
                                    wire:model.live='employee_selected_id'>
                                </td>
                            <td>{{ $dataemployee->firstItem() + $key }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->adress }}</td>
                            <td>
                                <a wire:click="edit({{ $data->id }})" class="btn btn-warning btn-sm">Edit</a>
                                <a wire:click="delete_confirmation({{ $data->id }})" class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">Del</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $dataemployee->links() }}

        </div>
        <!-- AKHIR DATA -->
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        SERIOUS, WANT DELETE THIS DATA?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" wire:click="delete()"
                            data-bs-dismiss="modal">DELETE</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
