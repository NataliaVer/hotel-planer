<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookedRoom;
use App\Models\Room;
use App\Http\Resources\HotelRoomResource;

use Illuminate\Support\Facades\Validator;

class HotelRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = auth()->user()->rooms->pluck('id')->toArray();

        $bookedRooms = BookedRoom::whereIn('room_id', $rooms)->where('confirmed', '0')->get();

        return response()->json([
            'success' => true,
            'data' => HotelRoomResource::collection($bookedRooms)
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = Validator::make($request->all(), [
            'room_id' => 'required',
            'first_name' => 'bail|required|max:50',
            'last_name' => 'bail|required|max:50',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|min:10|max:14',
            'confirmed' => '',
            'date_from' => 'bail|required',
            'date_to' => 'bail|required'
        ]);

        if($data->fails()){
            return response()->json([
                'success' => false,
                'data' => 'validation error',
                'errors' => $data->errors()
            ], 401);
        }

        try {

            $bookedRoom = BookedRoom::create([
                'room_id' => $request->room_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'confirmed' => (!$request->confirmed) ? 0 : 1,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to
            ]);

            return response()->json([
                'success' => true,
                'data' => $bookedRoom->id
            ]);
            
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'data' => $e->getMessage()
            ]);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bookedRoom = BookedRoom::find($id);

        if (!$bookedRoom) {
            return response()->json([
            'success' => false,
            'data' => '"id" booked room not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => new HotelRoomResource($bookedRoom)
            ]);

        // return new HotelRoomResource($bookedRoom);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bookedRoom = BookedRoom::find($id);

        // return response()->json([
        //     'success' => false,
        //     'data' => $request->all()
        //     ]);

        if (!$bookedRoom) {
            return response()->json([
            'success' => false,
            'data' => '"id" booked room not found'
            ]);
        }


        $data = Validator::make($request->all(), [
            'room_id' => 'required',
            'first_name' => 'bail|required|max:50',
            'last_name' => 'bail|required|max:50',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|min:10|max:14',
            'confirmed' => '',
            'date_from' => 'bail|required',
            'date_to' => 'bail|required'
        ]);

        if($data->fails()){
            return response()->json([
                'success' => false,
                'data' => 'validation error',
                'errors' => $data->errors()
            ], 401);
        }

        // return response()->json([
        //     'success' => false,
        //     'data' => $data
        //     ]);

        $updated = $bookedRoom->update([
            'room_id' => $request->room_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'confirmed' => (!$request->confirmed) ? 0 : 1,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to
        ]);

        if ($updated) {
            return response()->json([
            'success' => true,
            'data' => $bookedRoom->id
            ]);
        } else {
            return response()->json([
            'success' => false,
            'data' => 'booked room can not be updated'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $bookedRoom = BookedRoom::find($id);

        if (!$bookedRoom) {
            return response()->json([
            'success' => false,
            'data' => '"id" booked room not found'
            ]);
        }

        $bookedRoom->delete();

        return response()->json([
            'success' => true,
            'data' => 'the reservation has been deleted'
            ]);
    }

    public function getroom($dateFrom, $dateTo) {

        $dateF = \Datetime::createFromFormat('Y-m-d', $dateFrom);
        $dateT = \Datetime::createFromFormat('Y-m-d', $dateTo);

        if (!$dateF || !$dateT) {
            return response()->json([
            'success' => false,
            'data' => 'no query parameters specified: dateFrom or dateTo'
            ]);
        }

        $rooms = auth()->user()->rooms->pluck('id')->toArray();

        $bookedRooms = BookedRoom::whereIn('room_id', $rooms)->where('created_at', '>=', $dateFrom)
                                                             ->where('created_at', '<=', $dateTo)
                                                             ->get();

        return response()->json([
            'success' => true,
            'data' => HotelRoomResource::collection($bookedRooms)
            ]);
    }

}
