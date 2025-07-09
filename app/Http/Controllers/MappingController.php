<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MappingController extends Controller
{
    public function index()
    {
        $rfidTags = DB::table('robots')->select('tag')->distinct()->whereNotNull('tag')->get();
        $ips = DB::table('robots')->select('ip')->distinct()->get();

        $rfidMappings = DB::table('rfid_mappings')->get();
        $ipMappings = DB::table('ip_mappings')->get();

        return view('dashboard.settingip', compact('rfidTags', 'ips', 'rfidMappings', 'ipMappings'));
    }

    public function storeRfid(Request $request)
    {
        $request->validate([
            'tag' => 'required|string',
            'location' => 'required|string|max:50',
        ]);

        DB::table('rfid_mappings')->insert([
            'tag' => $request->tag,
            'location_label' => $request->location
        ]);

        return redirect()->route('mapping.index')->with('success', 'RFID data added');
    }

    public function storeIp(Request $request)
    {
        $request->validate([
            'ip' => 'required|ip',
            'robot' => 'required|string|max:50',
        ]);

        DB::table('ip_mappings')->insert([
            'ip' => $request->ip,
            'robot_name' => $request->robot
        ]);

        return redirect()->route('mapping.index')->with('success', 'IP data added');
    }

    public function editRfid($id)
    {
        $rfid = DB::table('rfid_mappings')->where('id', $id)->first();
        return view('dashboard.editrfid', compact('rfid'));
    }

    public function editIp($id)
    {
        $ip = DB::table('ip_mappings')->where('id', $id)->first();
        return view('dashboard.editip', compact('ip'));
    }

    public function updateRfid(Request $request, $id)
    {
        $request->validate([
            'tag' => 'required|string',
            'location' => 'required|string|max:50',
        ]);

        DB::table('rfid_mappings')->where('id', $id)->update([
            'tag' => $request->tag,
            'location_label' => $request->location
        ]);

        return redirect()->route('mapping.index')->with('success', 'RFID data updated');
    }

    public function updateIp(Request $request, $id)
    {
        $request->validate([
            'ip' => 'required|ip',
            'robot' => 'required|string|max:50',
        ]);

        DB::table('ip_mappings')->where('id', $id)->update([
            'ip' => $request->ip,
            'robot_name' => $request->robot
        ]);

        return redirect()->route('mapping.index')->with('success', 'IP data updated');
    }

    public function destroyRfid($id)
    {
        DB::table('rfid_mappings')->where('id', $id)->delete();
        return redirect()->route('mapping.index')->with('success', 'RFID data deleted');
    }

    public function destroyIp($id)
    {
        DB::table('ip_mappings')->where('id', $id)->delete();
        return redirect()->route('mapping.index')->with('success', 'IP data deleted');
    }
}
