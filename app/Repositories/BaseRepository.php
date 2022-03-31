<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Http\Request;

class BaseRepository
{
  public function curDateTime()
  {
    return date('Y-m-d, H:i:s');
  }

  public function handleSingleFileUpload($file, $path): string
  {
    $fileName = mt_rand(1, 9999) . time() . '.' . $file->extension();
    $file->move(public_path($path), $fileName);
    return $fileName;
  }

  public function handleMultiFileUpload($request, $key, $path, $limit = 50): array
  {
    $filesNames = [];
    foreach ($request->{$key} as $key => $file) :
      if($key < $limit) {
        $name =  mt_rand(1, 99999999) . time() . '.' . $file->extension();
        $file->move(public_path($path), $name);
        $filesNames[] = $name;
      }
    endforeach;
    return $filesNames;
  }

}
