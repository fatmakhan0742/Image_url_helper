
<!-- store the image as url(helper) -->

private function storeFile($file)
    {

        $name = $file->getClientOriginalName();
        $name = pathinfo($name, PATHINFO_FILENAME);
        $name = str_replace(' ', '_', $name);
        //unique name to image
        $newImageName = uniqid() . '-' . $name . '.' . $file->extension();

        $filePath = 'rswT20/' . $newImageName;
        // dd($filePath);
        # store image
        Storage::disk('s3')->put($filePath, file_get_contents($file));

        // $bucket_name = env('AWS_BUCKET');
        // $region = env('AWS_DEFAULT_REGION');

        $bucket_name = env("AWS_BUCKET");
        $region = env("AWS_DEFAULT_REGION");

        $url = 'https://' . $bucket_name . '.s3.' . $region . '.amazonaws.com/' . $filePath;

        return $url;
    }


    <!-- call while storing (controller-->
     

  public function store(Request $request) : RedirectResponse
    { 
        $input = $request->all();
        $var= $this->storeFile($request->image);
        // dd($input);
        $data = [
            'name' => $request->name,
            'description' =>$request->description,
             'price'=>$request->price,
              'status' =>$request->status,
            'image' => $var,

        ];
       
        Shipping::create($data);
        
        return redirect('shipping')->with('flash_message', 'sucessfully Addedd!');
      
        
    }


    <!-- view -->
    <td><img src="{{ $item->image }}" alt="img" style="width:250px;height:100px;">
    </td>


