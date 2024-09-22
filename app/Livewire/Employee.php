<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $email;
    public $adress;
    public $update_data = false;
    public $employee_id;
    public $search;
    public $employee_selected_id = [];
    public $sort_colomn = 'name';
    public $sort_direction = 'asc';
    public function store()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'adress' => 'required',
        ];
        $message = [
            'name.required' => 'Name Required',
            'email.required' => 'Email Required',
            'email.email' => ' Must Email Format',
            'adress.required' => 'Adress Required',
        ];
        $validate = $this->validate($rules, $message);
        ModelsEmployee::create($validate);
        session()->flash('message', 'Data Add, Success');
        $this->clear();
    }
    public function edit($id)
    {
        $data = ModelsEmployee::find($id);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->adress = $data->adress;
        $this->update_data = true;
        $this->employee_id = $id;
    }
    public function delete()
    {
        if ($this->employee_id != '') {
            $id = $this->employee_id;
            ModelsEmployee::find($id)->delete();
        }
        if (count($this->employee_selected_id)) {
            for ($i = 0; $i < count($this->employee_selected_id); $i++) {
                ModelsEmployee::find($this->employee_selected_id[$i])->delete();
            }
        }
        session()->flash('message', 'Data Delete, Success');
        $this->clear();
    }
    public function delete_confirmation($id)
    {
        $this->employee_id = $id;
    }
    public function clear()
    {
        $this->name = '';
        $this->email = '';
        $this->adress = '';
        $this->update_data = false;
        $this->employee_id = '';
        $this->employee_selected_id = [];
    }
    public function update()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'adress' => 'required',
        ];
        $message = [
            'name.required' => 'Name Required',
            'email.required' => 'Email Required',
            'email.email' => ' Must Email Format',
            'adress.required' => 'Adress Required',

        ];
        $validate = $this->validate($rules, $message);
        $data = ModelsEmployee::find($this->employee_id);
        $data->update($validate);
        session()->flash('message', 'Data Update, Success');
        $this->clear();
    }
    public function sort($colomn_name)
    {
        $this->sort_colomn = $colomn_name;
        $this->sort_direction = $this->sort_direction == 'asc' ? 'desc' : 'asc';
    }
    public function render()
    {
        if ($this->search != NULL) {
            $data = ModelsEmployee::where('name', 'like', '%' . $this->search . '%')
                ->orwhere('email', 'like', '%' . $this->search . '%')
                ->orwhere('adress', 'like', '%' . $this->search . '%')
                ->orderBy($this->sort_colomn,$this->sort_direction)->paginate(2);
        } else {
            $data = ModelsEmployee::orderBy($this->sort_colomn,$this->sort_direction)->paginate(2);
        }
        return view('livewire.employee', ['dataemployee' => $data]);
    }
}
