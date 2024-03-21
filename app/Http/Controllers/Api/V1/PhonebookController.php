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

    /**
     * @OA\Get(
     *     path="/phonebook",
     *     tags={"Phonebook"},
     *     summary="Gera o relatório dos nomes e números da agenda",
     *     operationId="listPhonebookContacts",
     *     @OA\Response(
     *         response=200,
     *         description="List of contacts",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example="1"),
     *                      @OA\Property(property="title", type="string", example="Example name"),
     *                      @OA\Property(property="email", type="string", example="example@example"),
     *                      @OA\Property(property="birthdate", type="string", format="date", example="yyyy-mm-dd"),
     *                      @OA\Property(property="CPF", type="string", example="99999999988"),
     *                      @OA\Property(property="phones", type="array", @OA\Items(type="string")),
     *                  )
     *              )
     *          )
     *     )
     * )
     */
    public function index()
    {
        return PhonebookResource::collection( Phonebook::all() );
    }

    /**
     * @OA\Post(
     *     path="/phonebook",
     *     tags={"Phonebook"},
     *     summary="Cria um nome e número ná agenda",
     *     operationId="createPhonebookContact",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     maxLength=100
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email"
     *                 ),
     *                 @OA\Property(
     *                     property="birthdate",
     *                     type="string",
     *                     format="date",
     *                     example="YYYY-MM-DD"
     *                 ),
     *                 @OA\Property(
     *                     property="CPF",
     *                     type="string",
     *                     description="Brazilian CPF number",
     *                     pattern="^\d{3}\.\d{3}\.\d{3}-\d{2}$"
     *                 ),
     *                 @OA\Property(
     *                     property="phones",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         format="telefone_com_ddd"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Phonebook contact created!",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Phonebook created!", "data": {"id": 1, "name": "John Doe", "email": "john@example.com", "birthdate": "1990-01-01", "CPF": "123.456.789-00", "phones": {"(123) 456-7890"}}}
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Something is wrong!"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Data invalid",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Data invalid", "errors": {"name": {"The name field is required."}}}
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(),
            [
                'name'      => 'required|max:100|unique',
                'email'     => 'required|email',
                'birthdate' => 'required|date_format:Y-m-d',
                'CPF'       => 'required|cpf|unique',
                'phones'    => 'required|array'
            ]);

        if ( $validator->fails() ){
            return $this->error('Data inválid!', 422, $validator->errors());
        }

        $data = $validator->validated();

        $data['phones'] = serialize($data['phones']);

        $created = Phonebook::create($data);

        if (!$created){
            return $this->error( 'Something is wrong!', 400 );
        }

        return $this->response('Phonebook created!', 200, new PhonebookResource( $created ));

    }

    /**
     * @OA\Put(
     *     path="/phonebook/{id}",
     *     tags={"Phonebook"},
     *     summary="Edita algum campo do cadastro da agenda",
     *     operationId="updatePhonebookContact",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the phonebook contact",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     maxLength=100
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email"
     *                 ),
     *                 @OA\Property(
     *                     property="birthdate",
     *                     type="string",
     *                     format="date",
     *                     example="YYYY-MM-DD"
     *                 ),
     *                 @OA\Property(
     *                     property="CPF",
     *                     type="string",
     *                     description="Brazilian CPF number",
     *                     pattern="^\d{3}\.\d{3}\.\d{3}-\d{2}$"
     *                 ),
     *                 @OA\Property(
     *                     property="phones",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         format="telefone_com_ddd"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Phonebook contact updated!",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Phone number updated!", "data": {"id": 1, "name": "John Doe", "email": "john@example.com", "birthdate": "1990-01-01", "CPF": "123.456.789-00", "phones": {"(123) 456-7890"}}}
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Something is wrong!"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Phone number not found!"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Data invalid",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Data invalid", "errors": {"name": {"The name field is required."}}}
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
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
            'phones'    => 'required|array'
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
            'phones'    => serialize($validated['phones'])

        ];

        $updated = $phonebook->update($createdArray);

        if (!$updated){
            return $this->error( 'Something is wrong!', 400 );
        }

        return $this->response('Phone number updated!', 200, $validated);
    }

    /**
     * @OA\Delete(
     *     path="/phonebook/{id}",
     *     tags={"Phonebook"},
     *     summary="Deleta um registro da agenda pelo id informado",
     *     operationId="deletePhonebookContact",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the phonebook contact",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Phone number deleted!",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Phone number deleted!"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Phone number not deleted!"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Phone number not found!"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
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
