<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExportController;
use App\Models\Admin;
use App\Models\AdminLeave;
use App\Models\AdminLeaveType;
use App\Models\AdminPermission;
use App\Models\AdminRole;
use App\Models\AdminSign;
use App\Models\AdminSignApply;
use App\Models\AdminSignStatistic;
use App\Models\AdminSignSummary;
use App\Models\DateSet;
use App\Models\TimeSet;
use App\Sdk\ArrayGroupBy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator, DB, Date, Excel, Hash, Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin:admin');
    }

    //公用页面
    public function index()
    {
        return view('admin/index');
    }

    //签到
    public function adminSignIn()
    {
        $admin_id = Auth::guard('admin')->user()->id;
        $now = Date::now();
        $now_date = $now->format('Y-m-d');
        if ($this->_adminSignCheck($admin_id, $now_date, 1)) {
            return $this->resp(10000, '您已签到');
        }
        return DB::transaction(function () use ($admin_id, $now_date, $now) {
            AdminSign::create(['admin_id' => $admin_id, 'sign_time' => $now, 'sign_type' => 1]);
            AdminSignStatistic::updateOrCreate(['admin_id' => $admin_id, 'sign_date' => $now_date],
                ['sign_in_time' => $now]);
            return $this->resp(0, '签到成功');
        });
    }

    //签退
    public function adminSignOut()
    {
        $admin_id = Auth::guard('admin')->user()->id;
        $now = Date::now();
        $now_date = $now->format('Y-m-d');
        $sign_id = $this->_adminSignCheck($admin_id, $now_date, 2);
        if ($sign_id) {
            return DB::transaction(function () use ($admin_id, $now_date, $sign_id, $now) {
                AdminSign::where('id', $sign_id)->update(['sign_time' => $now]);
                AdminSignStatistic::updateOrCreate(['admin_id' => $admin_id, 'sign_date' => $now_date],
                    ['sign_out_time' => $now]);
                return $this->resp(0, '签退成功');
            });
        }
        return DB::transaction(function () use ($admin_id, $sign_id, $now_date, $now) {
            AdminSign::create(['admin_id' => $admin_id, 'sign_time' => $now, 'sign_type' => 2]);
            AdminSignStatistic::updateOrCreate(['admin_id' => $admin_id, 'sign_date' => $now_date],
                ['sign_out_time' => $now]);
            return $this->resp(0, '签退成功');
        });
    }

    //签到签退判断
    private function _adminSignCheck($admin_id, $date, $sign_type)
    {
        $rs = AdminSign::where('admin_id', $admin_id)
            ->whereDate('sign_time', $date)
            ->where('sign_type', $sign_type)->first();
        if ($rs) {
            return $rs->id;
        } else {
            return 0;
        }
    }

    //我的考勤
    public function mysign()
    {
        $data['leave_type'] = AdminLeaveType::get();
        return view('admin/mysign', ['data' => $data]);
    }

    //申请请假
    public function adminAskForLeave(Request $request)
    {
        $rule = [
            'leave_start_time' => 'required|date_format:Y-m-d H:i:s',
            'leave_end_time' => 'required|date_format:Y-m-d H:i:s|after:leave_start_time',
            'leave_type' => 'required|integer|between:1,5',//请假类型：1-调休，2-事假，3-病假，4-出差，5-下现场
            'leave_reason' => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;
        $leave_start_time = $request->leave_start_time;
        $leave_end_time = $request->leave_end_time;
        $tmp = AdminLeave::where('admin_id', $admin_id)
            ->where('leave_status', 1)
            ->where(function ($query) use ($leave_start_time, $leave_end_time) {
                $query->orWhere(function ($query) use ($leave_start_time) {
                    $query->whereDate('leave_start_time', '<=', $leave_start_time)
                        ->whereDate('leave_end_time', '>', $leave_start_time);
                })->orWhere(function ($query) use ($leave_end_time) {
                    $query->whereDate('leave_start_time', '<', $leave_end_time)
                        ->whereDate('leave_end_time', '>=', $leave_end_time);
                });
            })
            ->first();
        if ($tmp) {
            return $this->resp(10000, '您提交的请假时间与已准假时间冲突，请核实修改后重新提交提交');
        }
        AdminLeave::create(['admin_id' => $admin_id, 'submit_time' => Date::now(),
            'leave_start_time' => $leave_start_time, 'leave_end_time' => $leave_end_time,
            'leave_type' => $request->leave_type, 'leave_reason' => $request->leave_reason]);
        return $this->resp(0, '提交成功');
    }

    //申请补签
    public function adminSignApply(Request $request)
    {
        $rule = [
            'sign_apply_date' => 'required|date_format:Y-m-d',
            'sign_apply_type' => 'required|integer|between:1,2',//补签类型：1-补到签，2-补退签
            'sign_apply_reason' => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;
        AdminSignApply::updateOrCreate(['admin_id' => $admin_id, 'sign_apply_date' => $request->sign_apply_date,
            'sign_apply_type' => $request->sign_apply_type, 'sign_apply_status' => 2],
            ['submit_time' => Date::now(), 'sign_apply_reason' => $request->sign_apply_reason]);
        return $this->resp(0, '提交成功');
    }

    //获取我的考勤
    public function getMySign(Request $request)
    {
        $admin_id = Auth::guard('admin')->user()->id;
        $rule = [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $now_date = Date::now()->add('+1 day')->format('Y-m-d');
        //日期设置信息
        $set_data = DateSet::select()
            ->whereDate('set_date', '>=', $start_date)
            ->whereDate('set_date', '<', $end_date)->get();
        //签到信息
        $sign = AdminSign::select('*', DB::raw("DATE_FORMAT(sign_time,'%Y-%m-%d') as sign_date,DATE_FORMAT(sign_time,'%H:%i:%s') as sign_hour"))
            ->whereDate('sign_time', '>=', $start_date)
            ->whereDate('sign_time', '<', $end_date)
            ->where('admin_id', $admin_id)->get();
        //请假信息
        $leave = AdminLeave::select()
            ->where(function ($query) use ($start_date, $end_date) {
                $query->orWhere(function ($query) use ($start_date, $end_date) {
                    $query->whereDate('leave_start_time', '>=', $start_date)
                        ->whereDate('leave_start_time', '<', $end_date);
                })->orWhere(function ($query) use ($start_date, $end_date) {
                    $query->whereDate('leave_end_time', '>', $start_date)
                        ->whereDate('leave_end_time', '<=', $end_date);
                });
            })
            ->where('admin_id', $admin_id)->get();
        //补签信息
        $sign_apply = AdminSignApply::select()
            ->whereDate('sign_apply_date', '>=', $start_date)
            ->whereDate('sign_apply_date', '<', $end_date)
            ->where('admin_id', $admin_id)->get();
        //获取每天结果
        $arr = array();
        while ($start_date < $end_date) {
            $arr = array_merge($arr, $this->_getDaySignInfo($start_date, $now_date, $set_data, $sign, $sign_apply, $leave));
            $start_date = Date::parse($start_date)->add('+1 day')->format('Y-m-d');
        }
        return $this->resp(0, $arr);
    }

    //获取某天休或班信息
    private function _getSetDateInfo($date, $set_date)
    {
        $rs = $set_date->where('set_date', $date)->first();
        if ($rs) {
            $tmp['start'] = $date;
            $tmp['title'] = '休';
            $tmp['className'] = 'bg-success';
            $tmp['type'] = 0;
        } else {
            $tmp['start'] = $date;
            $tmp['title'] = '班';
            $tmp['className'] = 'bg-info';
            $tmp['type'] = 1;
        }
        $tmp['order'] = 1;
        return $tmp;
    }

    //获取某天补签信息
    private function _getSignApplyInfo($date, $sign_type, $sign_apply)
    {
        //3-无签到信息，2-补签信息待审核，1-补签信息通过，0-补签信息驳回
        //1-签到，2-签退
        if (!$sign_apply->isEmpty()) {
            $rs = $sign_apply->where('sign_apply_date', $date);
            if (!$rs->isEmpty()) {
                $tmp = $rs->where('sign_apply_type', $sign_type);
                if (!$tmp->isEmpty()) {
                    return $tmp->pluck('sign_apply_status')->last();
                }
                return 3;
            }
            return 3;
        }
        return 3;
    }

    //获某天签到信息
    private function _getSignInInfo($date, $now_date, $sign, $className, $sign_apply)
    {
        $tmp1 = $this->_getSignApplyInfo($date, 1, $sign_apply);
        $tmp2 = $sign_apply->where('sign_apply_date', $date)->where('sign_apply_type', 1);
        switch ($tmp1) {
            case 0:
                $sign_apply_title = '补签驳回';
                $tmp['apply_reason'] = $tmp2->pluck('sign_apply_reason')->last();
                $tmp['approval_note'] = $tmp2->pluck('approval_note')->last();
                break;
            case 1:
                $sign_apply_title = '已补签';
                break;
            case 2:
                $sign_apply_title = '补签待审';
                $tmp['apply_reason'] = $tmp2->pluck('sign_apply_reason')->last();
                break;
            default:
                $sign_apply_title = null;
        }
        $rs = $sign->where('sign_date', $date)->where('sign_type', 1)->first();
        if ($rs) {
            $tmp['start'] = $date;
            if ($rs->sign_status) {
                $tmp['title'] = '已签到 ' . $rs->sign_hour;
                $tmp['className'] = $className ?: 'bg-info';
            } else {
                $tmp['title'] = $className ? '已签到 ' . $rs->sign_hour : '迟到 ' . $rs->sign_hour . ' ' . $sign_apply_title;
                if ($tmp1 == 1) {
                    $tmp['className'] = $className ?: 'bg-info';
                } else {
                    $tmp['className'] = $className ?: 'bg-warning';
                }
            }
        } else {
            $tmp['start'] = $date;
            if ($date < $now_date) {
                $tmp['title'] = '未签到 ' . $sign_apply_title;
            } else {
                $tmp['title'] = '待签到 ' . $sign_apply_title;
            }
            if ($tmp1 == 1) {
                $tmp['className'] = $className ?: 'bg-info';
            } else {
                $tmp['className'] = $className ?: 'bg-danger';
            }
        }
        $tmp['order'] = 2;
        return $tmp;
    }

    //获某天签退信息
    private function _getSignOutInfo($date, $now_date, $sign, $className, $sign_apply)
    {
        $tmp1 = $this->_getSignApplyInfo($date, 2, $sign_apply);
        $tmp2 = $sign_apply->where('sign_apply_date', $date)->where('sign_apply_type', 2);
        switch ($tmp1) {
            case 0:
                $sign_apply_title = '补签驳回';
                $tmp['apply_reason'] = $tmp2->pluck('sign_apply_reason')->last();
                $tmp['approval_note'] = $tmp2->pluck('approval_note')->last();
                break;
            case 1:
                $sign_apply_title = '已补签';
                break;
            case 2:
                $sign_apply_title = '补签待审';
                $tmp['apply_reason'] = $tmp2->pluck('sign_apply_reason')->last();
                break;
            default:
                $sign_apply_title = null;
        }
        $rs = $sign->where('sign_date', $date)->where('sign_type', 2)->first();
        if ($rs) {
            $tmp['start'] = $date;
            if ($rs->sign_status) {
                $tmp['title'] = '已签退 ' . $rs->sign_hour;
                $tmp['className'] = $className ?: 'bg-info';
            } else {
                $tmp['title'] = $className ? '已签退 ' . $rs->sign_hour : '早退 ' . $rs->sign_hour . ' ' . $sign_apply_title;
                if ($tmp1 == 1) {
                    $tmp['className'] = $className ?: 'bg-info';
                } else {
                    $tmp['className'] = $className ?: 'bg-warning';
                }
            }
        } else {
            $tmp['start'] = $date;
            if ($date < $now_date) {
                $tmp['title'] = '未签退 ' . $sign_apply_title;
            } else {
                $tmp['title'] = '待签退 ' . $sign_apply_title;
            }
            if ($tmp1 == 1) {
                $tmp['className'] = $className ?: 'bg-info';
            } else {
                $tmp['className'] = $className ?: 'bg-danger';
            }
        }
        $tmp['order'] = 3;
        return $tmp;
    }

    //获取某天请假信息
    private function _getLeaveInfo($date, $leave)
    {
        //0-无请假信息，1-调休，2-事假，3-病假，4-出差，5-下现场
        if (!$leave->isEmpty()) {
            $rs = $leave->reject(function ($v) use ($date) {
                $start = Date::parse($v['leave_start_time'])->format('Y-m-d');
                $stop = Date::parse($v['leave_end_time'])->format('Y-m-d');
                if ($date < $start || $date > $stop) {
                    return $v;
                }
            })->values()->last();
            if ($rs) {
                $tmp['start'] = $date;
                switch ($rs->leave_status) {
                    case 0:
                        $leave_status = '驳回';
                        break;
                    case 2:
                        $leave_status = '待审';
                        break;
                    default:
                        $leave_status = null;
                }
                $tmp['title'] = $rs->leave_type_name . $leave_status;
                $tmp['className'] = 'bg-primary';
                $tmp['order'] = 4;
                $tmp['leave_info'] = $rs;
                return $tmp;
            }
            return 0;
        }
        return 0;
    }

    //获取每天考勤结果
    private function _getDaySignInfo($date, $now_date, $set_date, $sign, $sign_apply, $leave)
    {
        $arr = array();
        //获取休息天信息
        $arr[] = $this->_getSetDateInfo($date, $set_date);
        if ($arr[0]['type']) {
            $className = null;
        } else {
            $className = 'bg-success';
        }
        //获取签到信息
        $arr[] = $this->_getSignInInfo($date, $now_date, $sign, $className, $sign_apply);
        //获取签退信息
        $arr[] = $this->_getSignOutInfo($date, $now_date, $sign, $className, $sign_apply);
        //获取请假信息
        $rs = $this->_getLeaveInfo($date, $leave);
        $rs && $arr[] = $rs;
        return $arr;
    }

    //修改密码
    public function changePassword(Request $request)
    {
        $rule = [
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $password = Admin::find($admin_id)->password;
        if (!Hash::check($old_password, $password)) {
            return $this->resp(10000, '您的初始密码不正确!');
        }
        if (Admin::where('id', $admin_id)->update(['password' => bcrypt($new_password)])) {
            return $this->resp(0, '修改密码成功!');
        }
        return $this->resp(10000, '修改密码失败!');
    }

    //上传头像
    public function uploadAvatar(Request $request)
    {
        $rule = [
            'avatar' => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $avatar = $request->avatar;
        if (!$this->_checkPicbase64($avatar)) {
            return $this->resp(10000, '请选择头像后上传！');
        }
        $base64 = explode(',', $avatar);
        $admin_id = Auth::guard('admin')->user()->id;

        $img = base64_decode($base64[1]);
        $disk = Storage::disk('avatar');
        $img_name = 'avatar-' . date('Y-m-d-H-i-s-') . $admin_id . '.png';
        $filename = $disk->put($img_name, $img);
        if ($filename) {
            $img_url = $disk->url($img_name);
            $admin = Admin::find($admin_id);
            $old_filename = substr($admin->avatar, 14);
            $admin->avatar = $img_url;
            $admin->save();
            $disk->delete($old_filename);
            return $this->resp(0, '上传成功!');
        }
        return $this->resp(10000, '上传失败!');
    }

    private function _checkPicbase64($base64)
    {
        $tmp = substr($base64, 0, 4);
        if ($tmp == 'data') {
            return 1;
        }
        return 0;
    }

    /*******日期事件视图*******/
    public function dateset()
    {
        $data['time_set'] = TimeSet::get();
        return view('admin/dateset', ['data' => $data]);
    }

    //获取日期事件
    public function getDateEvent(Request $request)
    {
        $rule = [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $rs = DateSet::select()->where('set_date', '>=', $request->start_date)
            ->where('set_date', '<', $request->end_date)->get();
        return $this->resp(0, $rs);
    }

    //设置日期事件
    public function setDateEvent(Request $request)
    {
        $rule = [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        return DB::transaction(function () use ($request) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            while ($start_date < $end_date) {
                DateSet::updateOrCreate(['set_date' => $start_date]);
                $start_date = Date::parse($start_date)->add('+1 day')->format('Y-m-d');
            }
            return $this->resp(0, '设置成功');
        });
    }

    //删除日期事件
    public function delDateEvent(Request $request)
    {
        $rule = [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        return DB::transaction(function () use ($request) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            if ($start_date == $end_date) {
                DateSet::where('set_date', $start_date)->delete();
            } else {
                while ($start_date < $end_date) {
                    DateSet::where('set_date', $start_date)->delete();
                    $start_date = Date::parse($start_date)->add('+1 day')->format('Y-m-d');
                }
            }
            return $this->resp(0, '删除成功');
        });
    }

    //设置夏季工作时间
    public function setSummerTime(Request $request)
    {
        $rule = [
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        return DB::transaction(function () use ($request) {
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            TimeSet::whereIn('set_month', ['06', '07', '08', '09'])
                ->update(['set_start_time' => $start_time, 'set_end_time' => $end_time]);
            return $this->resp(0, '设置成功');
        });
    }

    //设置冬季工作时间
    public function setWinterTime(Request $request)
    {
        $rule = [
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        return DB::transaction(function () use ($request) {
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            TimeSet::whereNotIn('set_month', ['06', '07', '08', '09'])
                ->update(['set_start_time' => $start_time, 'set_end_time' => $end_time]);
            return $this->resp(0, '设置成功');
        });
    }

    /*******角色设置视图*******/
    public function roleset()
    {
        return view('admin/roleset');
    }

    //获取角色列表
    public function getRoleList(Request $request)
    {
        $rule = [
            'page' => 'integer',
            'item' => 'integer',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $search = $request->search;
        $data = AdminRole::where(function ($q) use ($search) {
            $search &&
            $q->orWhere('admin_roles.name', 'like', '%' . $search . '%')
                ->orwhere('admin_roles.display_name', 'like', '%' . $search . '%')
                ->orwhere('admin_roles.description', 'like', '%' . $search . '%');
        })->orderBy('id', 'DESC')->paginate($request->item);
        return $this->resp(0, $data);
    }

    //删除角色
    public function delRole(Request $request)
    {
        $rule = [
            'role_id' => 'required|integer|exists:admin_roles,id'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $rs = AdminRole::where('id', $request->role_id)->delete();
        if ($rs) {
            return $this->resp(0, '删除成功');
        }
        return $this->resp(10000, '删除失败');
    }

    //添加角色
    public function addRole(Request $request)
    {
        $rule = [
            'role_name' => 'required|max:100|unique:admin_roles,name',
            'role_display_name' => 'required|max:50',
            'role_description' => 'required|max:100'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $rs = AdminRole::create(['name' => $request->role_name, 'display_name' => $request->role_display_name,
            'description' => $request->role_description]);
        if ($rs) {
            return $this->resp(0, '添加成功');
        }
        return $this->resp(10000, '添加失败');
    }

    //编辑角色
    public function editRole(Request $request)
    {
        $rule = [
            'role_id' => 'required|integer|exists:admin_roles,id',
            'role_name' => 'required|max:100|unique:admin_roles,name,' . $request->role_id,
            'role_display_name' => 'required|max:50',
            'role_description' => 'required|max:100'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $rs = AdminRole::where('id', $request->role_id)
            ->update(['name' => $request->role_name, 'display_name' => $request->role_display_name,
                'description' => $request->role_description]);
        if ($rs) {
            return $this->resp(0, '修改成功');
        }
        return $this->resp(10000, '修改失败');
    }

    //获取角色的权限
    public function getAdminPerms(Request $request)
    {
        $rule = [
            'role_id' => 'required|integer|exists:admin_roles,id'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_perms = AdminRole::find($request->role_id)->perms;
        $data = AdminPermission::get()->map(function ($v) use ($admin_perms) {
            if ($admin_perms->where('id', $v['id'])->first()) {
                $v['prem_status'] = 1;
            } else {
                $v['prem_status'] = 0;
            }
            return $v;
        })->sortByDesc('prem_status')->values()->all();
        return $this->resp(0, $data);
    }

    //分配权限
    public function allotPrems(Request $request)
    {
        $rule = [
            'role_id' => 'required|integer|exists:admin_roles,id',
            'permission_id' => 'required|integer|exists:admin_permissions,id',
            'perm_allot_status' => 'required|integer|between:0,1'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $role = AdminRole::find($request->role_id);
        $perm_id = $request->permission_id;
        if ($request->perm_allot_status) {
            $role->attachPermissions([$perm_id]);
            return $this->resp(0, '分配权限成功');
        } else {
            $role->detachPermissions([$perm_id]);
            return $this->resp(0, '取消权限成功');
        }
    }

    /*******补签审核视图*******/
    public function signapplylist()
    {
        return view('admin/signapplylist');
    }

    //获取补签申请列表
    public function getSignApplyList(Request $request)
    {
        $rule = [
            'page' => 'integer',
            'item' => 'integer',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $search = $request->search;
        $data = AdminSignApply::select('admininfo.name as realname', 'admin_sign_apply.*',
            'admin_sign_apply.sign_apply_type as sign_apply_type_name', 'approval.name as approval_name')
            ->leftjoin('admininfo', 'admininfo.admin_id', '=', 'admin_sign_apply.admin_id')
            ->leftjoin('admininfo as approval', 'approval.admin_id', '=', 'admin_sign_apply.sign_apply_approval')
            ->where(function ($q) use ($search) {
                $search &&
                $q->orWhere('admininfo.name', 'like', '%' . $search . '%')
                    ->orWhere('approval.name', 'like', '%' . $search . '%')
                    ->orWhere('admin_sign_apply.sign_apply_date', 'like', '%' . $search . '%');
            })
            ->orderBy('admin_sign_apply.sign_apply_status', 'DESC')
            ->orderBy('admin_sign_apply.sign_apply_date', 'DESC')
            ->paginate($request->item);
        return $this->resp(0, $data);
    }

    //审核补签申请
    public function checkSignApply(Request $request)
    {
        $rule = [
            'sign_apply_id' => 'required|integer|exists:admin_sign_apply,id',
            'approval_note' => 'max:200',
            'sign_apply_status' => 'required|integer|between:0,1'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;
        return DB::transaction(function () use ($admin_id, $request) {
            $rs = AdminSignApply::where('id', $request->sign_apply_id)
                ->update(['sign_apply_approval' => $admin_id, 'approval_time' => Date::now(),
                    'approval_note' => $request->approval_note, 'sign_apply_status' => $request->sign_apply_status]);
            if ($rs) {
                $sign_apply = AdminSignApply::find($request->sign_apply_id);
                if ($request->sign_apply_status == 1) {
                    $user_id = $sign_apply->admin_id;
                    $now_date = $sign_apply->sign_apply_date;
                    AdminSignStatistic::updateOrCreate(['admin_id' => $user_id, 'sign_date' => $now_date]);
                }
                return $this->resp(0, '操作成功');
            }
            return $this->resp(10000, '操作失败');
        });
    }

    //批量审核补签申请
    public function checkMoreSignApply(Request $request)
    {
        $rule = [
            'sign_apply_id_arr' => 'required|array',
            'approval_note' => 'max:200',
            'sign_apply_status' => 'required|integer|between:0,1'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;

        return DB::transaction(function () use ($admin_id, $request) {
            $rs = AdminSignApply::whereIn('id', $request->sign_apply_id_arr)
                ->update(['sign_apply_approval' => $admin_id, 'approval_time' => Date::now(),
                    'approval_note' => $request->approval_note, 'sign_apply_status' => $request->sign_apply_status]);
            if ($rs) {
                $sign_apply = AdminSignApply::whereIn('id', $request->sign_apply_id_arr)->get();
                foreach ($sign_apply as $v) {
                    if ($request->sign_apply_status == 1) {
                        $user_id = $v->admin_id;
                        $now_date = $v->sign_apply_date;
                        AdminSignStatistic::updateOrCreate(['admin_id' => $user_id, 'sign_date' => $now_date]);
                    }
                }
                return $this->resp(0, '操作成功');
            }
            return $this->resp(10000, '操作失败');
        });
    }

    /*******请假审核视图*******/
    public function leaveapplylist()
    {
        return view('admin/leaveapplylist');
    }

    //获取请假申请列表
    public function getLeaveApplyList(Request $request)
    {
        $rule = [
            'page' => 'integer',
            'item' => 'integer',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $search = $request->search;
        $data = AdminLeave::select('admininfo.name as realname', 'admin_leave.*', 'approval.name as approval_name')
            ->leftjoin('admininfo', 'admininfo.admin_id', '=', 'admin_leave.admin_id')
            ->leftjoin('admininfo as approval', 'approval.admin_id', '=', 'admin_leave.leave_approval')
            ->where(function ($q) use ($search) {
                $search &&
                $q->orWhere('admininfo.name', 'like', '%' . $search . '%')
                    ->orWhere('approval.name', 'like', '%' . $search . '%')
                    ->orWhere('admin_leave.submit_time', 'like', '%' . $search . '%');
            })
            ->orderBy('admin_leave.leave_status', 'DESC')
            ->orderBy('admin_leave.submit_time', 'DESC')
            ->paginate($request->item);
        return $this->resp(0, $data);
    }

    //按天创建请假信息
    private function _createLeaveInfo($leave_id)
    {
        $leave = AdminLeave::find($leave_id);
        $admin_id = $leave->admin_id;
        $leave_start_time = $leave->leave_start_time;
        $leave_end_time = $leave->leave_end_time;
        $leave_type = $leave->leave_type;

        $start_date = Date::parse($leave_start_time)->format('Y-m-d');
        $end_date = Date::parse($leave_end_time)->format('Y-m-d');

        while ($start_date <= $end_date) {
            //获取当天上班时间
            $month = Date::parse($start_date)->format('m');
            $time_set = TimeSet::find($month);
            //获取上班时间与请假时间交集
            $ins = $this->_getTimeIntersection($start_date . ' ' . $time_set->set_start_time,
                $start_date . ' ' . $time_set->set_end_time, $leave_start_time, $leave_end_time);
            if ($ins) {
                $tmp_start = Date::parse($ins[0])->format('H:i');
                $tmp_end = Date::parse($ins[1])->format('H:i');
                $leave_time = $tmp_start . '-' . $tmp_end;
                if (($tmp_start == $time_set->set_start_time) && ($tmp_end == $time_set->set_end_time)) {
                    $leave_time_type = 1;
                } else {
                    $leave_time_type = 2;
                }
                AdminSignStatistic::updateOrCreate(['admin_id' => $admin_id, 'sign_date' => $start_date],
                    ['leave_type' => $leave_type, 'leave_start_time' => $leave_start_time,
                        'leave_end_time' => $leave_end_time, 'leave_time' => $leave_time,
                        'leave_time_type' => $leave_time_type]);
            }
            $start_date = Date::parse($start_date)->add('+1 day')->format('Y-m-d');
        }
    }

    //获取两个时间段的交集
    private function _getTimeIntersection($beginTime1, $endTime1, $beginTime2, $endTime2)
    {
        $time = Array();
        if ($beginTime2 > $beginTime1) {
            if ($beginTime2 >= $endTime1) {
                return null;
            } else {
                $time[] = $beginTime2;
                if ($endTime2 < $beginTime2) {
                    $time[] = $endTime2;
                } else {
                    $time[] = $endTime1;
                }
                return $time;
            }
        } else {
            if ($endTime2 > $beginTime1) {
                if ($endTime2 < $endTime1) {
                    $time[] = $beginTime1;
                    $time[] = $endTime2;
                } else {
                    $time[] = $beginTime1;
                    $time[] = $endTime1;
                }
                return $time;
            } else {
                return null;
            }
        }
    }

    //审核请假申请
    public function checkLeaveApply(Request $request)
    {
        $rule = [
            'leave_id' => 'required|integer|exists:admin_leave,id',
            'approval_note' => 'max:200',
            'leave_status' => 'required|integer|between:0,1'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;
        return DB::transaction(function () use ($admin_id, $request) {
            $rs = AdminLeave::where('id', $request->leave_id)
                ->update(['leave_approval' => $admin_id, 'approval_time' => Date::now(),
                    'approval_note' => $request->approval_note, 'leave_status' => $request->leave_status]);
            if ($rs) {
                $this->_createLeaveInfo($request->leave_id);
                return $this->resp(0, '操作成功');
            }
            return $this->resp(10000, '操作失败');
        });
    }

    //批量审核请假申请
    public function checkMoreLeaveApply(Request $request)
    {
        $rule = [
            'leave_id_arr' => 'required|array',
            'approval_note' => 'max:200',
            'leave_status' => 'required|integer|between:0,1'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $admin_id = Auth::guard('admin')->user()->id;
        return DB::transaction(function () use ($admin_id, $request) {
            $rs = AdminLeave::whereIn('id', $request->leave_id_arr)
                ->update(['leave_approval' => $admin_id, 'approval_time' => Date::now(),
                    'approval_note' => $request->approval_note, 'leave_status' => $request->leave_status]);
            if ($rs) {
                foreach ($request->leave_id_arr as $v) {
                    $this->_createLeaveInfo($v);
                }
                return $this->resp(0, '操作成功');
            }
            return $this->resp(10000, '操作失败');
        });
    }

    /*******考勤统计视图*******/
    public function signandleavestatistics()
    {
        return view('admin/signandleavestatistics');
    }

    //按月获取考勤统计
    public function getMonthAttendanceStatistics(Request $request)
    {
        $rule = [
            'page' => 'integer',
            'item' => 'integer',
            'month' => 'date_format:Y-m'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $year = $request->month ? Date::parse($request->month)->format('Y') : Date::now()->format('Y');
        $month = $request->month ? Date::parse($request->month)->format('m') : Date::now()->format('m');
        $search = $request->search;
        $rs = AdminSignStatistic::select('admin_sign_statistic.*', 'admininfo.name  as realname')
            ->leftjoin('admininfo', 'admininfo.admin_id', '=', 'admin_sign_statistic.admin_id')
            ->leftjoin('admins', 'admins.id', '=', 'admininfo.admin_id')
            ->where('admins.is_attendance', 1)
            ->whereYear('admin_sign_statistic.sign_date', $year)
            ->whereMonth('admin_sign_statistic.sign_date', $month)
            ->where(function ($q) use ($search) {
                $search &&
                $q->orWhere('admininfo.name', 'like', '%' . $search . '%')
                    ->orWhere('admin_sign_statistic.sign_date', 'like', '%' . $search . '%');
            })
            ->paginate($request->item);
        return $this->resp(0, $rs);
    }

    //按月获取考勤统计导出EXCEL
    public function importMonthAttendanceStatistics(Request $request)
    {
        $rule = [
            'month' => 'required|date_format:Y-m'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $year = Date::parse($request->month)->format('Y');
        $month = Date::parse($request->month)->format('m');
        $search = $request->search;
        $rs = AdminSignStatistic::select('admininfo.name  as realname', 'admin_sign_statistic.*')
            ->leftjoin('admininfo', 'admininfo.admin_id', '=', 'admin_sign_statistic.admin_id')
            ->leftjoin('admins', 'admins.id', '=', 'admininfo.admin_id')
            ->where('admins.is_attendance', 1)
            ->whereYear('admin_sign_statistic.sign_date', $year)
            ->whereMonth('admin_sign_statistic.sign_date', $month)
            ->where(function ($q) use ($search) {
                $search &&
                $q->orWhere('admininfo.name', 'like', '%' . $search . '%')
                    ->orWhere('admin_sign_statistic.sign_date', 'like', '%' . $search . '%');
            })
            ->get();
        $id = 1;
        $cellData = Array();
        foreach ($rs as $v) {
            if ($v->sign_in_time) {
                $sign_in_time = Date::parse($v->sign_in_time)->format('H:i:s');
                //补签到状态：0-未补签，1-已补签，2-迟到
                if ($v->sign_in_status == 1) {
                    $sign_in_time_show = $v->sign_in_time_format;
                } elseif ($v->sign_in_status == 2) {
                    $sign_in_time_show = $sign_in_time . '(迟到)';
                } else {
                    $sign_in_time_show = $sign_in_time;
                }
            } else {
                if ($v->sign_in_status == 1) {
                    $sign_in_time_show = $v->sign_in_time_format;
                } else {
                    $sign_in_time_show = '未签到';
                }
            }
            if ($v->sign_out_time) {
                $sign_in_time = Date::parse($v->sign_out_time)->format('H:i:s');
                //补签到状态：0-未补签，1-已补签，2-早退
                if ($v->sign_out_status == 1) {
                    $sign_out_time_show = $v->sign_out_time_format;
                } elseif ($v->sign_out_status == 2) {
                    $sign_out_time_show = $sign_in_time . '(早退)';
                } else {
                    $sign_out_time_show = $sign_in_time;
                }
            } else {
                if ($v->sign_out_status == 1) {
                    $sign_out_time_show = $v->sign_out_time_format;
                } else {
                    $sign_out_time_show = '未签退';
                }
            }
            $cellData[] = array($id, $v->realname, $v->sign_date, $v->date_format, $sign_in_time_show, $sign_out_time_show,
                $v->leave_type_name, $v->leave_time);
            $id = $id + 1;
        }
        $cellHarder = ['序号', '姓名', '日期', '星期', '签到时间', '签退时间', '请假情况', '请假时间'];
        return new ExportController(collect($cellData), '月考勤统计表.xls', $cellHarder);
    }

    /*******考勤汇总视图*******/
    public function signandleavesummary()
    {
        return view('admin/signandleavesummary');
    }

    //按月获取考勤汇总
    public function getMonthAttendanceSummary(Request $request)
    {
        $rule = [
            'month' => 'date_format:Y-m'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $year = $request->month ? Date::parse($request->month)->format('Y') : Date::now()->format('Y');
        $month = $request->month ? Date::parse($request->month)->format('m') : Date::now()->format('m');
        $search = $request->search ? array(['admininfo.name', 'like', '%' . $request->search . '%']) : array();
        $rs = AdminSignSummary::select('admininfo.name  as realname', 'admin_sign_statistic.*', 'admins.id as admin_id')
            ->rightjoin('admins', 'admins.id', '=', 'admin_sign_statistic.admin_id')
            ->leftjoin('admininfo', 'admininfo.admin_id', '=', 'admins.id')
            ->where('admins.is_attendance', 1)
            ->where(function ($query) use ($year, $month) {
                $query->orWhere(function ($query) use ($year, $month) {
                    $query->whereYear('admin_sign_statistic.sign_date', $year)
                        ->whereMonth('admin_sign_statistic.sign_date', $month);
                })
                    ->orWhere('admin_sign_statistic.sign_date', null);
            })
            ->where($search)
            ->get();
        $group_by_fields = [
            'admin_id' => function ($value) {
                return $value;
            }
        ];
        $getAttendanceDay = $this->_getAttendanceDay($request->month);
        $group_by_value = [
            'admin_id' => function ($data) {
                return array_column($data, 'admin_id')[0];
            },
            'realname' => function ($data) {
                return array_column($data, 'realname')[0];
            },
            'attendance_day' => function ($data) use ($getAttendanceDay) {
                return $getAttendanceDay[0];
            },
            'attendance_time' => function ($data) use ($getAttendanceDay) {
                return $getAttendanceDay[1];
            },
            'sign_day_sum' => function ($data) {
                return round(array_sum(array_column($data, 'sign_day_sum')), 1);
            },
            'date_attendance_time' => function ($data) {
                return round(array_sum(array_column($data, 'date_attendance_time')), 1);
            },
            'date_other_time' => function ($data) {
                return round(array_sum(array_column($data, 'date_other_time')), 1);
            },
            'late_num' => function ($data) {
                return round(array_sum(array_column($data, 'late_num')), 1);
            },
            'left_early_num' => function ($data) {
                return round(array_sum(array_column($data, 'left_early_num')), 1);
            },
            'date_leave_day' => function ($data) {
                return round(array_sum(array_column($data, 'date_leave_day')), 1);
            },
            'date_leave_time' => function ($data) {
                return round(array_sum(array_column($data, 'date_leave_time')), 1);
            }
        ];
        $grouped = ArrayGroupBy::groupBy($rs->toArray(), $group_by_fields, $group_by_value);
        return $this->resp(0, $grouped);
    }

    //获取当月应出勤天数和时长
    private function _getAttendanceDay($date)
    {
        $rs = Array();
        $month_day = date('t', strtotime($date));
        $year = Date::parse($date)->format('Y');
        $month = Date::parse($date)->format('m');
        $set_day = DateSet::whereYear('set_date', $year)
            ->whereMonth('set_date', $month)
            ->count();
        $all_day = $month_day - $set_day;
        $rs[] = $all_day;
        $sign_time = TimeSet::where('set_month', $month)->first();
        $tmp = Date::parse($sign_time->set_end_time)->timespanm($sign_time->set_start_time);
        $rs[] = round($all_day * $tmp / 60, 1);
        return $rs;
    }

    //按月获取考勤汇总导出EXCEL
    public function importMonthAttendanceSummary(Request $request)
    {
        $rule = [
            'month' => 'date_format:Y-m'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $year = $request->month ? Date::parse($request->month)->format('Y') : Date::now()->format('Y');
        $month = $request->month ? Date::parse($request->month)->format('m') : Date::now()->format('m');
        $search = $request->search ? array(['admininfo.name', 'like', '%' . $request->search . '%']) : array();
        $rs = AdminSignSummary::select('admininfo.name  as realname', 'admin_sign_statistic.*', 'admins.id as admin_id')
            ->rightjoin('admins', 'admins.id', '=', 'admin_sign_statistic.admin_id')
            ->leftjoin('admininfo', 'admininfo.admin_id', '=', 'admins.id')
            ->where('admins.is_attendance', 1)
            ->where(function ($query) use ($year, $month) {
                $query->orWhere(function ($query) use ($year, $month) {
                    $query->whereYear('admin_sign_statistic.sign_date', $year)
                        ->whereMonth('admin_sign_statistic.sign_date', $month);
                })
                    ->orWhere('admin_sign_statistic.sign_date', null);
            })
            ->where($search)
            ->get();
        $group_by_fields = [
            'admin_id' => function ($value) {
                return $value;
            }
        ];
        $getAttendanceDay = $this->_getAttendanceDay($request->month);
        $group_by_value = [
            'realname' => function ($data) {
                return array_column($data, 'realname')[0];
            },
            'attendance_day' => function ($data) use ($getAttendanceDay) {
                return $getAttendanceDay[0];
            },
            'attendance_time' => function ($data) use ($getAttendanceDay) {
                return $getAttendanceDay[1];
            },
            'sign_day_sum' => function ($data) {
                return round(array_sum(array_column($data, 'sign_day_sum')), 1);
            },
            'date_attendance_time' => function ($data) {
                return round(array_sum(array_column($data, 'date_attendance_time')), 1);
            },
            'date_other_time' => function ($data) {
                return round(array_sum(array_column($data, 'date_other_time')), 1);
            },
            'late_num' => function ($data) {
                return round(array_sum(array_column($data, 'late_num')), 1);
            },
            'left_early_num' => function ($data) {
                return round(array_sum(array_column($data, 'left_early_num')), 1);
            },
            'date_leave_day' => function ($data) {
                return round(array_sum(array_column($data, 'date_leave_day')), 1);
            },
            'date_leave_time' => function ($data) {
                return round(array_sum(array_column($data, 'date_leave_time')), 1);
            }
        ];
        $grouped = ArrayGroupBy::groupBy($rs->toArray(), $group_by_fields, $group_by_value);
        $cellHarder = ['姓名', '应出勤(天)', '应出勤(时)', '实出勤(天)', '实出勤(时)', '加班(时)', '迟到(次)',
            '早退(次)', '请假(天)', '请假(时)'];
        return new ExportController(collect($grouped), '月考勤汇总表.xls', $cellHarder);

    }

    private function _getDateFormat($date)
    {
        $date_set = DateSet::find($date);
        $x = null;
        if ($date_set) {
            $x = '休';
        } else {
            $x = '班';
        }
        $n = Date::parse($date)->format('N');
        $m = null;
        switch ($n) {
            case 1:
                $m = '星期一(' . $x . ')';
                break;
            case 2:
                $m = '星期二(' . $x . ')';
                break;
            case 3:
                $m = '星期三(' . $x . ')';
                break;
            case 4:
                $m = '星期四(' . $x . ')';
                break;
            case 5:
                $m = '星期五(' . $x . ')';
                break;
            case 6:
                $m = '星期六(' . $x . ')';
                break;
            case 7:
                $m = '星期日(' . $x . ')';
                break;
            default:
                $m = null;
        }
        return $m;
    }

    //获取考勤汇总详情
    public function getAdminAttendanceSummary(Request $request)
    {
        $rule = [
            'admin_id' => 'required|integer|exists:admins,id',
            'month' => 'required|date_format:Y-m'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return $this->resp(10000, $validator->messages()->first());
        }
        $year = $request->month ? Date::parse($request->month)->format('Y') : Date::now()->format('Y');
        $month = $request->month ? Date::parse($request->month)->format('m') : Date::now()->format('m');
        $rs = AdminSignStatistic::select('admininfo.admin_id', 'admininfo.name  as realname', 'admin_sign_statistic.*')
            ->where('admininfo.admin_id', $request->admin_id)
            ->leftjoin('admininfo', 'admininfo.admin_id', '=', 'admin_sign_statistic.admin_id')
            ->whereYear('admin_sign_statistic.sign_date', $year)
            ->whereMonth('admin_sign_statistic.sign_date', $month)
            ->get();
        $month_day = date('t', strtotime($request->month));
        $start = $request->month . '-01';
        $end = $request->month . '-' . $month_day;
        $arr = Array();
        while ($start <= $end) {
            $tmp = $rs->where('sign_date', $start)->first();
            if ($tmp) {
                $arr[] = $tmp;
            } else {

                $arr[] = ["admin_id" => null,
                    "realname" => null,
                    "id" => null,
                    "sign_date" => $start,
                    "sign_in_time" => null,
                    "sign_out_time" => null,
                    "leave_type" => null,
                    "leave_start_time" => null,
                    "leave_end_time" => null,
                    "leave_time" => null,
                    "leave_time_type" => null,
                    "leave_type_name" => null,
                    "sign_in_time_format" => null,
                    "sign_out_time_format" => null,
                    "sign_in_status" => null,
                    "sign_out_status" => null,
                    "date_format" => $this->_getDateFormat($start)];
            }
            $start = Date::parse($start)->add('+1 day')->format('Y-m-d');
        }
        return $this->resp(0, $arr);
    }

    /*******我的信息视图*******/
    public function myinfo()
    {
        return view('admin/myinfo');
    }

    /*******人员管理列表视图*******/
    public function adminmanagelist()
    {
        return view('admin/adminmanagelist');
    }

}
