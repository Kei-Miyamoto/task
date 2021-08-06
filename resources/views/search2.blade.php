<div class="row">
        <div class="col-sm-4">
            <div class="text-center my-4">
                <h3 class="brown border p-2">商品検索</h3>
            </div>
            {!! Form::open(['route' => 'search', 'method' => 'get']) !!}
                <div class="form-group">
                    {!! Form::label('text', '商品名') !!}
                    {!! Form::text('name' ,'', ['class' => 'form-control', 'placeholder' => '指定なし'] ) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('tactics', '会社名') !!}
                    {!! Form::select('tactics', ['指定なし' => '指定なし'] + Config::get('') , '指定なし') !!}
                </div>
                {!! Form::submit('検索', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
        <div class="col-sm-8">
            <div class="text-center my-4">
                <h3 class="brown p-2">ユーザ一覧</h3>
            </div>

            <div class="container">
                <!--検索ボタンが押された時に表示されます-->
                @if(!empty($data))
                    <div class="my-2 p-0">
                        <div class="row  border-bottom text-center">
                            <div class="col-sm-4">
                                <p>ユーザ名</p>
                            </div>
                            <div class="col-sm-4">
                                <p>棋力</p>
                            </div>
                            <div class="col-sm-4">
                                <p>好きな戦法</p>
                            </div>
                        </div>
                      //検索条件に一致したユーザを表示します
                        @foreach($data as $item)
                                <div class="row py-2 border-bottom text-center">
                                    <div class="col-sm-4">
                                        <a href="">{{ $item->name }}</a>
                                    </div>
                                    <div class="col-sm-4">
                                        {{ $item->strength }}
                                    </div>
                                    <div class="col-sm-4">
                                        {{ $item->tactics }}
                                    </div>
                                </div>
                        @endforeach
                    </div>
                    {{ $data->appends(request()->input())->render('pagination::bootstrap-4') }}
                @endif
            </div>
        </div>
    </div>
