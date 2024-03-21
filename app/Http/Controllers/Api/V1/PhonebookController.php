<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PhonebookResource;
use App\Models\Phonebook;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhonebookController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return PhonebookResource::collection( Phonebook::all() );
    }

    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(),
            [
                'name'      => 'required|max:100',
                'email'     => 'required|email',
                'birthdate' => 'required|date_format:Y-m-d',
                'CPF'       => 'required|cpf',
                'phones'    => 'required|telefone_com_ddd'
            ]);

        if ( $validator->fails() ){
            return $this->error('Data inválid!', 422, $validator->errors());
        }

        $created = Phonebook::create($validator->validated());

        if (!$created){
            return $this->error( 'Something is wrong!', 400 );
        }

        return $this->response('Phonebook created!', 200, new PhonebookResource( $created ));

    }

    public function update(Request $request, string $id)
    {
        $phonebook = Phonebook::find($id);

        if(  is_null( $phonebook ) ){
            return $this->error('Phone number not found!', 404);
        }

        $validator = Validator::make( $request->all(), [
            'name'      => 'required|max:100',
            'email'     => 'required|email',
            'birthdate' => 'required|date_format:Y-m-d',
            'CPF'       => 'required|cpf',
            'phones'    => 'required|telefone_com_ddd'
        ]);

        if ( $validator->fails() ){
            return $this->error('Data inválid!', 422, $validator->errors());
        }

        $validated = $validator->validated();

        $createdArray = [

            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'birthdate' => $validated['birthdate'],
            'CPF'       => $validated['CPF'],
            'phones'    => $validated['phones']

        ];

        $updated = $phonebook->update($createdArray);

        if (!$updated){
            return $this->error( 'Something is wrong!', 400 );
        }

        return $this->response('Phone number updated!', 200, $validated);
    }

    public function destroy(string $id)
    {
        $phonebook = Phonebook::find($id);

        if(  is_null( $phonebook ) ){
            return $this->error('Phone number not found!', 404);
        }

        $deleted = Phonebook::destroy( $id );

        if (!$deleted){
            return $this->error('Phone number not deleted!', 400);
        }

        return $this->response('Phone number deleted!', 200);
    }

}
