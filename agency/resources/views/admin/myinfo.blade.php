@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">我的信息</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">我的信息</li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10 btn-themecolor">
                        <i class="ti-settings text-white"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="row">
        <div class="col-lg-12 col-xlg-12 col-md-12">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#admin_base_info"
                                            role="tab">基本信息</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#work_study_info"
                                            role="tab">工作及学习</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reward_punishment_info"
                                            role="tab">业绩及奖惩</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#certificate_info"
                                            role="tab">所获证书</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#attachment_info" role="tab">附件</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane" id="admin_base_info" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 col-xs-4">
                                    <div class="u-img">
                                        <input type="file" class="dropify"
                                               data-show-remove="false" data-height="200" disabled
                                               data-default-file="{{ Auth::guard('admin')->user()->avatar }}"/>
                                    </div>
                                </div>
                                <div class="col-md-10 col-xs-20">
                                    <div class="row">
                                        <div class="col-md-2 col-xs-4 b-l b-r"><strong>所属部门</strong>
                                            <br>
                                            <p class="text-muted">综合管理部</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4 b-r"><strong>行政职务</strong>
                                            <br>
                                            <p class="text-muted">人力资源主管</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4 b-r"><strong>人员类别</strong>
                                            <br>
                                            <p class="text-muted">其他</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4"><strong>入职时间</strong>
                                            <br>
                                            <p class="text-muted">2005-06-30</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2 col-xs-4 b-l b-r"><strong>姓名</strong>
                                            <br>
                                            <p class="text-muted">杜鹏</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4 b-r"><strong>性别</strong>
                                            <br>
                                            <p class="text-muted">男</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4 b-r"><strong>出生年月</strong>
                                            <br>
                                            <p class="text-muted">1982-12-06</p>
                                        </div>
                                        <div class="col-md-4 col-xs-8"><strong>身份证号码</strong>
                                            <br>
                                            <p class="text-muted">622801198212060030</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2 col-xs-4 b-l b-r"><strong>最高学历</strong>
                                            <br>
                                            <p class="text-muted">研究生</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4 b-r"><strong>毕业院校</strong>
                                            <br>
                                            <p class="text-muted">西北师范大学</p>
                                        </div>
                                        <div class="col-md-4 col-xs-8 b-r"><strong>所学专业</strong>
                                            <br>
                                            <p class="text-muted">计算机应用技术</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4"><strong>毕业时间</strong>
                                            <br>
                                            <p class="text-muted">2005-06-30</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2 col-xs-4 b-l b-r"><strong>所获职称</strong>
                                            <br>
                                            <p class="text-muted">高级工程师</p>
                                        </div>
                                        <div class="col-md-6 col-xs-12 b-r"><strong>职称类别</strong>
                                            <br>
                                            <p class="text-muted">国家注册安全工程师执业资格</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4"><strong>工作年限</strong>
                                            <br>
                                            <p class="text-muted">12年</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2 col-xs-4 b-l b-r"><strong>手机号码</strong>
                                            <br>
                                            <p class="text-muted">13919618048</p>
                                        </div>
                                        <div class="col-md-8 col-xs-16"><strong>现在住址</strong>
                                            <br>
                                            <p class="text-muted">余杭区瓶窑镇桂花溪园南区6-404</p>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane active" id="timeline" role="tabpanel">
                        <div class="card-body">
                            <div class="profiletimeline">
                                <div class="sl-item">
                                    <div class="sl-left"><img src="../assets/images/users/1.jpg" alt="user"
                                                              class="img-circle"/></div>
                                    <div class="sl-right">
                                        <div><a href="#" class="link">John Doe</a> <span
                                                    class="sl-date">5 minutes ago</span>
                                            <p>assign a new task <a href="#"> Design weblayout</a></p>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-6 m-b-20"><img
                                                            src="../assets/images/big/img1.jpg" alt="user"
                                                            class="img-responsive radius"/></div>
                                                <div class="col-lg-3 col-md-6 m-b-20"><img
                                                            src="../assets/images/big/img2.jpg" alt="user"
                                                            class="img-responsive radius"/></div>
                                                <div class="col-lg-3 col-md-6 m-b-20"><img
                                                            src="../assets/images/big/img3.jpg" alt="user"
                                                            class="img-responsive radius"/></div>
                                                <div class="col-lg-3 col-md-6 m-b-20"><img
                                                            src="../assets/images/big/img4.jpg" alt="user"
                                                            class="img-responsive radius"/></div>
                                            </div>
                                            <div class="like-comm"><a href="javascript:void(0)" class="link m-r-10">2
                                                    comment</a> <a href="javascript:void(0)" class="link m-r-10"><i
                                                            class="fa fa-heart text-danger"></i> 5 Love</a></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="sl-item">
                                    <div class="sl-left"><img src="../assets/images/users/2.jpg" alt="user"
                                                              class="img-circle"/></div>
                                    <div class="sl-right">
                                        <div><a href="#" class="link">John Doe</a> <span
                                                    class="sl-date">5 minutes ago</span>
                                            <div class="m-t-20 row">
                                                <div class="col-md-3 col-xs-12"><img src="../assets/images/big/img1.jpg"
                                                                                     alt="user"
                                                                                     class="img-responsive radius"/>
                                                </div>
                                                <div class="col-md-9 col-xs-12">
                                                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer
                                                        nec odio. Praesent libero. Sed cursus ante dapibus diam. </p> <a
                                                            href="#" class="btn btn-success"> Design weblayout</a></div>
                                            </div>
                                            <div class="like-comm m-t-20"><a href="javascript:void(0)"
                                                                             class="link m-r-10">2 comment</a> <a
                                                        href="javascript:void(0)" class="link m-r-10"><i
                                                            class="fa fa-heart text-danger"></i> 5 Love</a></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="sl-item">
                                    <div class="sl-left"><img src="../assets/images/users/3.jpg" alt="user"
                                                              class="img-circle"/></div>
                                    <div class="sl-right">
                                        <div><a href="#" class="link">John Doe</a> <span
                                                    class="sl-date">5 minutes ago</span>
                                            <p class="m-t-10"> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed
                                                nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum.
                                                Praesent mauris. Fusce nec tellus sed augue semper </p>
                                        </div>
                                        <div class="like-comm m-t-20"><a href="javascript:void(0)" class="link m-r-10">2
                                                comment</a> <a href="javascript:void(0)" class="link m-r-10"><i
                                                        class="fa fa-heart text-danger"></i> 5 Love</a></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="sl-item">
                                    <div class="sl-left"><img src="../assets/images/users/4.jpg" alt="user"
                                                              class="img-circle"/></div>
                                    <div class="sl-right">
                                        <div><a href="#" class="link">John Doe</a> <span
                                                    class="sl-date">5 minutes ago</span>
                                            <blockquote class="m-t-10">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="profile" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-xs-6 b-r"><strong>Full Name</strong>
                                    <br>
                                    <p class="text-muted">Johnathan Deo</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong>Mobile</strong>
                                    <br>
                                    <p class="text-muted">(123) 456 7890</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong>Email</strong>
                                    <br>
                                    <p class="text-muted">johnathan@admin.com</p>
                                </div>
                                <div class="col-md-3 col-xs-6"><strong>Location</strong>
                                    <br>
                                    <p class="text-muted">London</p>
                                </div>
                            </div>
                            <hr>
                            <p class="m-t-30">Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
                                enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede
                                mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean
                                vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend
                                ac, enim.</p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took a galley of type and scrambled it to make a type specimen book. It has
                                survived not only five centuries </p>
                            <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker
                                including versions of Lorem Ipsum.</p>
                            <h4 class="font-medium m-t-30">Skill Set</h4>
                            <hr>
                            <h5 class="m-t-30">Wordpress <span class="pull-right">80%</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="80"
                                     aria-valuemin="0" aria-valuemax="100" style="width:80%; height:6px;"><span
                                            class="sr-only">50% Complete</span></div>
                            </div>
                            <h5 class="m-t-30">HTML 5 <span class="pull-right">90%</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="90"
                                     aria-valuemin="0" aria-valuemax="100" style="width:90%; height:6px;"><span
                                            class="sr-only">50% Complete</span></div>
                            </div>
                            <h5 class="m-t-30">jQuery <span class="pull-right">50%</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="50"
                                     aria-valuemin="0" aria-valuemax="100" style="width:50%; height:6px;"><span
                                            class="sr-only">50% Complete</span></div>
                            </div>
                            <h5 class="m-t-30">Photoshop <span class="pull-right">70%</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="70"
                                     aria-valuemin="0" aria-valuemax="100" style="width:70%; height:6px;"><span
                                            class="sr-only">50% Complete</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="settings" role="tabpanel">
                        <div class="card-body">
                            <form class="form-horizontal form-material">
                                <div class="form-group">
                                    <label class="col-md-12">Full Name</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Johnathan Doe"
                                               class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="johnathan@admin.com"
                                               class="form-control form-control-line" name="example-email"
                                               id="example-email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Password</label>
                                    <div class="col-md-12">
                                        <input type="password" value="password" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Phone No</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="123 456 7890"
                                               class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Message</label>
                                    <div class="col-md-12">
                                        <textarea rows="5" class="form-control form-control-line"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Select Country</label>
                                    <div class="col-sm-12">
                                        <select class="form-control form-control-line">
                                            <option>London</option>
                                            <option>India</option>
                                            <option>Usa</option>
                                            <option>Canada</option>
                                            <option>Thailand</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="addRoleModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">添加角色</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>角色标识</label>
                            <input type="text" class="form-control"
                                   id="add-admin-role-name"></div>
                        <div class="form-group">
                            <label>角色名称</label>
                            <input type="text" class="form-control"
                                   id="add-admin-role-display-name"></div>
                        <div class="form-group">
                            <label>角色描述</label>
                            <input type="text" class="form-control"
                                   id="add-admin-role-description"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="add-admin-role"
                            class="btn btn-success">添加
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="editRoleModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">编辑角色</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>角色标识</label>
                            <input type="text" class="form-control" value=""
                                   id="edit-admin-role-name"></div>
                        <div class="form-group">
                            <label>角色名称</label>
                            <input type="text" class="form-control" value=""
                                   id="edit-admin-role-display-name"></div>
                        <div class="form-group">
                            <label>角色描述</label>
                            <input type="text" class="form-control" value=""
                                   id="edit-admin-role-description"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="edit-admin-role"
                            class="btn btn-success">修改
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bs-example-modal-lg fade show" id="PermListModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">权限分配</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover toggle-circle"
                           data-page-size="12" id="admin_perms_table"></table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="confirmDelRole" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">操作提示</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h2 class="center-block" style="margin:0px auto;display:table;">是否删除？</h2>
                    <p class="center-block" style="margin:0px auto;display:table;">删除后不能恢复!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="del-admin-role"
                            class="btn btn-success">确定
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/locale/bootstrap-table-zh-CN.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script>
        $(function () {
            var admin_role_id = null;
            $('#admin_role_table').bootstrapTable({
                url: 'getRoleList',
                ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                cache: false,
                method: 'POST',
                contentType: "application/x-www-form-urlencoded",
                dataField: "data",
                pageNumber: 1,
                pagination: true,
                queryParams: queryParams,
                sidePagination: 'server',
                pageSize: 10,//单页记录数
                pageList: [10, 15, 20],
                responseHandler: responseHandler,
                columns: [{
                    field: 'SerialNumber',
                    title: '序号',
                    formatter: function (value, row, index) {
                        var pageSize = $('#admin_role_table').bootstrapTable('getOptions').pageSize;//通过表的#id 可以得到每页多少条
                        var pageNumber = $('#admin_role_table').bootstrapTable('getOptions').pageNumber;//通过表的#id 可以得到当前第几页
                        return pageSize * (pageNumber - 1) + index + 1;
                    }
                }, {
                    field: 'name',
                    title: '角色标识'
                }, {
                    field: 'display_name',
                    title: '角色名称'
                }, {
                    field: 'description',
                    title: '角色描述'
                }, {
                    field: 'id',
                    title: '操作',
                    formatter: operateFormatter
                }],
                onPostBody: onPostBody
            });
            function queryParams(params) {
                return {
                    page: (params.offset / params.limit) + 1,
                    item: params.limit,
                    search: $('#demo-input-search2').val()
                }
            }

            function responseHandler(result) {
                var errcode = result.code;//在此做了错误代码的判断
                if (errcode) {
                    return;
                }
                return {
                    total: result.data.total,
                    data: result.data.data
                };
            }

            function operateFormatter(value, row, index) {
                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn allotAdminPerms" data-adminroleid=' + value + ' data-toggle="tooltip" data-original-title="分配权限"><i class="ti-key" aria-hidden="true"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editAdminRole" data-adminroleindex=' + index + ' data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delAdminRole" data-adminroleid=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
            }

            function refresh() {
                $('#admin_role_table').bootstrapTable('refresh', {url: 'getRoleList'});
            }

            function refresh1() {
                $('#admin_perms_table').bootstrapTable('refresh', {url: 'getAdminPerms'});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();
                $('.editAdminRole').click(function () {
                    var data = $('#admin_role_table').bootstrapTable('getData');
                    var index = $(this).attr('data-adminroleindex');
                    admin_role_id = data[index].id;
                    $('#editRoleModal').modal('show');
                    $('#edit-admin-role-name').val(data[index].name);
                    $('#edit-admin-role-display-name').val(data[index].display_name);
                    $('#edit-admin-role-description').val(data[index].description);
                });
                $(".delAdminRole").click(function () {
                    admin_role_id = $(this).attr('data-adminroleid');
                    $('#confirmDelRole').modal('show');
                });
                $('.allotAdminPerms').click(function () {
                    var admin_role_id = $(this).attr('data-adminroleid');
                    $('#PermListModal').modal('show');
                    $('#admin_perms_table').bootstrapTable({
                        url: 'getAdminPerms',
                        ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                        cache: false,
                        method: 'POST',
                        contentType: "application/x-www-form-urlencoded",
                        dataField: "data",
                        pageNumber: 1,
                        pagination: true,
                        queryParams: queryParams1,
                        search: true,
                        sidePagination: 'client',
                        pageSize: 10,
                        responseHandler: responseHandler1,
                        columns: [{
                            field: 'SerialNumber',
                            title: '序号',
                            formatter: function (value, row, index) {
                                return index + 1;
                            }
                        }, {
                            field: 'name',
                            title: '权限标识'
                        }, {
                            field: 'display_name',
                            title: '权限名称'
                        }, {
                            field: 'description',
                            title: '权限描述'
                        }, {
                            field: 'id',
                            title: '操作',
                            formatter: operateFormatter1
                        }],
                        onPostBody: onPostBody1
                    });

                    function queryParams1(params) {
                        return {
                            role_id: admin_role_id
                        }
                    }

                    function responseHandler1(result) {
                        var errcode = result.code;
                        if (errcode) {
                            return;
                        }
                        return {
                            total: result.data.length,
                            data: result.data
                        };
                    }

                    function operateFormatter1(value, row, index) {
                        if (row.prem_status) {
                            return '<input type="checkbox" checked class="allotPerms" data-perm_id=' + value + ' />';
                        } else {
                            return '<input type="checkbox" class="allotPerms" data-perm_id=' + value + ' />';
                        }
                    }

                    function onPostBody1(res) {
                        $(".allotPerms").bootstrapSwitch({
                            onText: "是",
                            offText: "否",
                            onColor: "success",
                            offColor: "info",
                            size: "small",
                            onSwitchChange: function (event, state) {
                                var admin_prem_id = $(this).attr('data-perm_id');
                                if (state == true) {
                                    $.ajax({
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        url: 'allotPrems',
                                        type: 'POST',
                                        data: {
                                            role_id: admin_role_id,
                                            permission_id: admin_prem_id,
                                            perm_allot_status: 1
                                        },
                                        success: function (doc) {
                                            if (doc.code) {
                                                $.toast({
                                                    heading: '警告',
                                                    text: doc.data,
                                                    position: 'top-right',
                                                    loaderBg: '#ff6849',
                                                    icon: 'warning',
                                                    hideAfter: 3000,
                                                    stack: 6
                                                });
                                                refresh1();
                                            } else {
                                                $('#editRoleModal').modal('hide');
                                                $.toast({
                                                    heading: '成功',
                                                    text: doc.data,
                                                    position: 'top-right',
                                                    loaderBg: '#ff6849',
                                                    icon: 'success',
                                                    hideAfter: 3000,
                                                    stack: 6
                                                });
                                            }
                                        },
                                        error: function (doc) {
                                            $.toast({
                                                heading: '错误',
                                                text: '网络错误，请稍后重试！',
                                                position: 'top-right',
                                                loaderBg: '#ff6849',
                                                icon: 'error',
                                                hideAfter: 3000,
                                                stack: 6
                                            });
                                            refresh1();
                                        }
                                    });
                                } else {
                                    $.ajax({
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        url: 'allotPrems',
                                        type: 'POST',
                                        data: {
                                            role_id: admin_role_id,
                                            permission_id: admin_prem_id,
                                            perm_allot_status: 0
                                        },
                                        success: function (doc) {
                                            if (doc.code) {
                                                $.toast({
                                                    heading: '警告',
                                                    text: doc.data,
                                                    position: 'top-right',
                                                    loaderBg: '#ff6849',
                                                    icon: 'warning',
                                                    hideAfter: 3000,
                                                    stack: 6
                                                });
                                                refresh1();
                                            } else {
                                                $('#editRoleModal').modal('hide');
                                                $.toast({
                                                    heading: '成功',
                                                    text: doc.data,
                                                    position: 'top-right',
                                                    loaderBg: '#ff6849',
                                                    icon: 'success',
                                                    hideAfter: 3000,
                                                    stack: 6
                                                });
                                            }
                                        },
                                        error: function (doc) {
                                            $.toast({
                                                heading: '错误',
                                                text: '网络错误，请稍后重试！',
                                                position: 'top-right',
                                                loaderBg: '#ff6849',
                                                icon: 'error',
                                                hideAfter: 3000,
                                                stack: 6
                                            });
                                            refresh1();
                                        }
                                    });
                                }
                            }
                        });
                    }
                });
            }

            $('#role-search').click(function () {
                refresh();
            });

            $('#add-admin-role').click(function () {
                var admin_role_name = $('#add-admin-role-name').val();
                var admin_role_display_name = $('#add-admin-role-display-name').val();
                var admin_role_description = $('#add-admin-role-description').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'addRole',
                    type: 'POST',
                    data: {
                        role_name: admin_role_name,
                        role_display_name: admin_role_display_name,
                        role_description: admin_role_description
                    },
                    success: function (doc) {
                        if (doc.code) {
                            $.toast({
                                heading: '警告',
                                text: doc.data,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'warning',
                                hideAfter: 3000,
                                stack: 6
                            });
                        } else {
                            $('#addRoleModal').modal('hide');
                            $('#add-admin-role-name').val('');
                            $('#add-admin-role-display-name').val('');
                            $('#add-admin-role-description').val('');
                            $.toast({
                                heading: '成功',
                                text: doc.data,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                            refresh()
                        }
                    },
                    error: function (doc) {
                        $.toast({
                            heading: '错误',
                            text: '网络错误，请稍后重试！',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3000,
                            stack: 6
                        });
                    }
                });
            });

            $('#edit-admin-role').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'editRole',
                    type: 'POST',
                    data: {
                        role_id: admin_role_id,
                        role_name: $('#edit-admin-role-name').val(),
                        role_display_name: $('#edit-admin-role-display-name').val(),
                        role_description: $('#edit-admin-role-description').val()
                    },
                    success: function (doc) {
                        if (doc.code) {
                            $.toast({
                                heading: '警告',
                                text: doc.data,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'warning',
                                hideAfter: 3000,
                                stack: 6
                            });
                        } else {
                            $('#editRoleModal').modal('hide');
                            $.toast({
                                heading: '成功',
                                text: doc.data,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                            refresh()
                        }
                    },
                    error: function (doc) {
                        $.toast({
                            heading: '错误',
                            text: '网络错误，请稍后重试！',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3000,
                            stack: 6
                        });
                    }
                });
            });

            $('#del-admin-role').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'delRole',
                    type: 'POST',
                    data: {
                        role_id: admin_role_id
                    },
                    success: function (doc) {
                        if (doc.code) {
                            $.toast({
                                heading: '警告',
                                text: doc.data,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'warning',
                                hideAfter: 3000,
                                stack: 6
                            });
                        } else {
                            $.toast({
                                heading: '成功',
                                text: doc.data,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                            $('#confirmDelRole').modal('hide');
                            refresh()
                        }
                    },
                    error: function (doc) {
                        $.toast({
                            heading: '错误',
                            text: '网络错误，请稍后重试！',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3000,
                            stack: 6
                        });
                    }
                });
            });

            $('#PermListModal').on('hide.bs.modal', function () {
                $('#admin_perms_table').bootstrapTable('destroy');
            })
        });
    </script>
@endsection