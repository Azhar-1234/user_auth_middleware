@extends('backEnd.master')
@section('mainContent')
 <div class="row">    
    <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-10">
         @if(Session::has('success'))
            <div class="alert alert-success">
                 {{ Session::get('success') }}
            @php
                Session::forget('success');
            @endphp
            </div>
        @endif
        <div class="card mt-2">
            <h5 class="card-header">User List</h5>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Image</th>
                            <th scope="col">status</th>                            
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
               
                    @foreach ($allData as $key => $data)
                    <tr>
                        <th scope="row">{{++$key}}</th>
                        <td style="font-size :16px;">{{$data->name}}</td>
                        <td style="font-size :16px;">{{$data->email}}</td>
                        <td style="font-size :16px;">
                            @if($data->role=='1')
                              <b>Admin</b>
                             @elseif($data->role=='2')
                                <b>Super Admin</b>
                            @else($data->role=='3')
                                <b>Doctor</b>
                            @endif
                        </td>
                        <td>   
                             <image id=""  src="{{url('upload/'.$data->image)}}" style="height:60;width:90px;">
                        </td>
                        <td style="font-size :16px;">
                            @if($data->status=='0')
                                <button class="btn btn-danger">Inactive</button>
                            @else
                                <button class="btn btn-info">Active</button>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('edit-user',[$data->id])}}" class="btn btn-sm btn-secondary"
                                    title="Edit"><i class="fa fa-edit"></i></a>
                            <a onclick="return confirm('are you sure?')" href="{{route('delete-user',[$data->id])}}" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                  
                    </tbody>
                </table>
            </div>
        </div>
    </div>        
    <div class="col-xl-4 col-lg-4 col-md-2 col-sm-2 col-2">
        <div class="card">
            <h5 class="card-header">User {{isset($editData)?'Edit':'Add'}}</h5>
            @if(Session::has('msg'))
             <div class="alert alert-success alert-dismissible fade show" role="alert">{{Session::get('msg')}}</div>
            @endif
            <div class="card-body">
                <form class="needs-validation" id="myForm" action="{{url(isset($editData)?'update-user':'store-user')}}" 
                    novalidate="" method="post" enctype="multipart/form-data"  >
                  <input type="hidden" name="id" value="{{isset($editData)?$editData->id:''}}">
                    @csrf
                    <div class="row ">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group">
                                
                            <div class="form-group">
                                <input  type="text" class="form-control" id="validationCustom01" 
                                    placeholder="Name " name="name" 
                                    value="{{isset($editData)? $editData->name:''}}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                            </div> 
                            <div class="form-group">
                                 <input  type="email" class="form-control" id="validationCustom01" 
                                placeholder="Email " name="email"
                                value="{{isset($editData)? $editData->email:''}}" > 
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input  type="password" class="form-control" id="validationCustom01" 
                                    placeholder="Password " name="password"
                                    value="{{isset($editData)? $editData->password:''}}"> 
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input  type="text" class="form-control" id="validationCustom01" 
                                placeholder="Mobile number " name="mobile" 
                                value="{{isset($editData)? $editData->mobile:''}}"> 
                                
                                @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                              <div class="form-group">
                                <label for="exampleInputName2"  class="pr-1  form-control-label">Status <font style="color: red">*</font></label><br>
                                  <select name="status" class="form-control form-control-sm">
                                  
                                   <option value="1"{{@$editData->status == 1 ?'selected':''}}>active</option>
                                   <option value="0"{{@$editData->status == 0 ?'selected':''}}>inactive</option>
                                  </select>
                                <font style="color: red">{{($errors->has('status'))? ($errors->first('name')):''}}</font>
                              </div>
                            <div class="form-group">
                                <label for="exampleInputName2"  class="pr-1  form-control-label">Select Role<font style="color: red">*</font></label><br>
                                  <select name="role" class="form-control form-control-sm">
                                   <option value="1"{{@$editData->role == 1 ?'selected':''}}>Admin</option>
                                   <option value="2"{{@$editData->role == 2 ?'selected':''}}>Super Admin</option>
                                   <option value="3"{{@$editData->role == 3 ?'selected':''}}>Doctor</option>
                                  </select>
                                <font style="color: red">{{($errors->has('status'))? ($errors->first('name')):''}}</font>
                            </div>
                            <div class="form-group">
                                <input type="file" name="image" class="form-control form-control-sm" id="image"><span>{{isset($editData)?'please again upload image ':' '}}</span><br>
                                <img src="/upload/{{@$editData->image}}" name="image" width="150px" style="margin-top: 10px" >
                                <font style="color: red">{{($errors->has('image'))? ($errors->first('name')):''}}</font>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group">
                            <button class="btn btn-primary mt-2" type="submit">{{isset($editData)?'Update':'Submit'}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endSection