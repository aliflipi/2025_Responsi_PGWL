<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PointsModel extends Model
{
    protected $table = 'points_tables';
    protected $guided = 'id';
    protected $fillable = [
        'geom',
        'name',
        'description',
        'tipe',
        'image',
        'user_id'
    ];
    public function geojson_points()
    {
        $points_tables = $this
            ->select(DB::raw('
                points_tables.id, ST_AsGeoJSON(geom) as geom,
                points_tables.name,
                points_tables.description,
                points_tables.tipe,
                points_tables.image,
                points_tables.created_at,
                points_tables.updated_at,
                u.name as user_created'))
            ->leftJoin('users as u', 'points_tables.user_id', '=', 'u.id')
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($points_tables as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'tipe' => $p->tipe,
                    'user_created' => $p->user_created,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'image' => $p->image
                ],
            ];
            array_push($geojson['features'], $feature);
        }
        return $geojson;
    }


    public function geojson_point($id)
    {
        $points_tables = $this
            ->select(DB::raw('id, st_asgeojson(geom) as geom, name, description, image, created_at, updated_at'))
            ->where('id', $id)
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($points_tables as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'tipe' => $p->tipe,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'image' => $p->image
                ],
            ];
            array_push($geojson['features'], $feature);
        }
        return $geojson;
    }
}
