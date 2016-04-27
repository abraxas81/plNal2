@extends('datatables.template2')

@section('breadcrumbs')
    {!! Breadcrumbs::render('klijenti.index') !!}

    @section('filters')
        <form id="admin_tariffs_internet_filter">
            <div class="splynx-nav-right">
                @include('partials.refreshTable')
                <a class="btn btn-xs btn-primary novi" data-toggle="modal" data-target="#Modal" data-action="klijenti">{{$textDodajGumba}}</a>
            </div>
        </form>
    @endsection
@endsection

@section('demo')
    <table id="table" class="display supertable table table-striped table-bordered">
        <thead>
        <tr>
            @foreach($tabelaStupci as $tabelaStupac)
                <th>{{$tabelaStupac[2]}}</th>
                <script type="text/javascript"> columns.push({!! json_encode($tabelaStupac) !!})</script>
            @endforeach
        </tr>
        </thead>
    </table>
@endsection

@section('form')
    @include('datatables.klijenti.form')
@endsection

@section('js')
    <script type="text/javascript">

        var tableId = "table";

        var url = '{{ url("klijenti/basic-data") }}';

        var filteri = {
        }

        var table = $('#'+tableId).DataTable({
            language : datableLanguage,
            ajax:{
                url : url,
                data: function (d) {
                    $.each(filteri, function(key,value){
                        d[key] = value;
                    })
                }
            },
            columns : vidljivost(columns)
        });

        $('.table_title').html('{{$naslovTabele}}');

    $('form').formValidation({
            framework: 'bootstrap',
            excluded: ':disabled',
            err: {
                container: 'tooltip'
            },
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            locale: 'hr_HR',
            fields: {
                Naziv: {
                    validators: {
                        notEmpty: {}
                    }
                }
            }
    });
    $(document).on('ready', function() {
        $(".supertable tbody").on("click", ".kopija", function () {
            $(this).attr('data-actionKopija');
            alert($(this).attr('data-actionKopija'));
        })
    });
    </script>
@endsection