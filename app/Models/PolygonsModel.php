<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolygonsModel extends Model
{
    protected $table = 'polygons';
    protected $guided = 'id';
    protected $fillable = [
        'geom',
        'name',
        'description',
        'image',
        'user_id'
    ];

    public function geojson_polygons()
    {
        $polygons = $this
            ->select(DB::raw('
            polygons.id, st_asgeojson(geom) as geom, st_area(geom, true) as luas_m2, st_area(geom, true)/1000000 as luas_km2, st_area(geom, true)/10000 as luas_hektar,
            polygons.name,
            polygons.description,
            polygons.image,
            polygons.created_at,
            polygons.updated_at,
            u.name as user_created'))
            ->leftJoin('users as u', 'polygons.user_id', '=', 'u.id')
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polygons as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'area_m2' => $p->luas_m2,
                    'area_km2' => $p->luas_km2,
                    'area_hektar' => $p->luas_hektar,
                    'user_created' => $p->user_created,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'image' => $p->image,
                ],
            ];
            array_push($geojson['features'], $feature);
        }
        return $geojson;
    }

    public function geojson_polygon($id)
    {
        $polygons = $this
            ->select(DB::raw('id, st_asgeojson(geom) as geom, st_area(geom, true) as luas_m2, st_area(geom, true)/1000000 as luas_km2, st_area(geom, true)/10000 as luas_hektar, name, description, image, created_at, updated_at'))
            ->where('id', $id)
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polygons as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'area_m2' => $p->luas_m2,
                    'area_km2' => $p->luas_km2,
                    'area_hektar' => $p->luas_hektar,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'image' => $p->image,
                ],
            ];
            array_push($geojson['features'], $feature);
        }
        return $geojson;
    }
}
