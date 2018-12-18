@section('styles')
    <style>
        .confinement-radio {
            margin: 10px;
        }
    </style>
@endsection

<div id="confinement_form" class="center-block">
    @if($user->isConfined())
        <form action="{{ route('confinements.destroy', $user->id) }}" method="POST">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button class="btn btn-success">取消禁言</button>
        </form>
    @else
        <button class="btn btn-danger" data-toggle="modal" data-target="#confinement-modal">禁言用户</button>

        <div class="modal fade" id="confinement-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('confinements.store', $user->id) }}" method="POST">
                        {{ csrf_field() }}

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title text-center" id="myModalLabel">选择禁言时间</h4>
                        </div>
                        <div class="modal-body text-center">
                            <span class="confinement-radio">
                                <input type="radio" class="custom-control-input" id="customRadio1" name="expired_in_days" value="1" required onchange="$('#is-permanent').val(0)">
                                <label class="custom-control-label" for="customRadio1">禁言一天</label>
                            </span>
                            <span class="confinement-radio">
                                <input type="radio" class="custom-control-input" id="customRadio2" name="expired_in_days" value="7" required onchange="$('#is-permanent').val(0)">
                                <label class="custom-control-label" for="customRadio2">禁言一周</label>
                            </span>
                            <span class="confinement-radio">
                                <input type="radio" class="custom-control-input" id="customRadio3" name="expired_in_days" value="30" required onchange="$('#is-permanent').val(0)">
                                <label class="custom-control-label" for="customRadio3">禁言一个月</label>
                            </span>
                            <span class="confinement-radio">
                                <input type="radio" class="custom-control-input" id="customRadio4" name="expired_in_days" value=null required onchange="$('#is-permanent').val(1)">
                                <label class="custom-control-label" for="customRadio4">永久禁言</label>
                            </span>
                            <input type="hidden" id="is-permanent" name="is_permanent" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-primary">确定</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    @endif
</div>
<hr>