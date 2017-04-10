@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"
          xmlns="http://www.w3.org/1999/html">
    @endsection

@section('content')
    <div class="container">
        <div class="row topNavbar">
            <div class="coincapLogo col-md-8 col-xs-4">
                <img src="/images/logo.jpg">
            </div>
            <div class="searchSection col-md-4 col-xs-8">
                <input type="text" class="search form-control" name="seacrhText" placeholder="Search for coins">
            </div>
        </div>
        <span class="counter pull-right"></span>
        <div class="coinChartDiv">
            <div class="table-responsive">
                <table id="tableClient" class="results table table-bordered">
                <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Name</th>
                    <th>Symbol</th>
                    <th>Price</th>
                    <th>Market cap</th>
                    <th>%24hr</th>
                </tr>
                </thead>
                <tbody>

                @foreach($coins as $i=>$coin)
                    <tr id="{{ $coin->name }}">
                        <td> {{$i+1}} </td>
                        <td> <a  href="{{url("/$coin->symbol")}}">{{ $coin->name }} </a></td>
                        <td>{{ $coin->symbol }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        clientReloadData();
        setInterval(function(){
            // document.write("hello");
            clientReloadData();

        }, 1000);

        function clientReloadData() {
            $.ajax({
                url: 'http://www.coincap.io/front',
            }).done(function(frontData){
                $('#tableClient > tbody  > tr').each(function() {
                    // console.log(this.id);
                    var byName = filterByProperty(frontData, 'long' , this.id)
                    // console.log(byName);
                    if(byName != undefined) {
                        $(this).find('td').eq(3).text(byName['price']);
                        $(this).find('td').eq(4).text(byName['mktcap']);
                        $(this).find('td').eq(5).text(byName['cap24hrChange']);
                    }
                    else {
                        $(this).find('td').eq(3).text("-");
                        $(this).find('td').eq(4).text("-");
                        $(this).find('td').eq(5).text("-");
                    }
                    // console.log(cell);
                });

            });
        }

        function filterByProperty(array, prop, value) {
            var filtered = [];
            for(var i = 0; i < array.length; i++){

                var obj = array[i];
                // console.log(obj);
                if(typeof(obj == "object")){
                    var item = obj;
                    if(item[prop] == value){
                        return item;
                    }
                }
            }
        }

    </script>
@endsection
