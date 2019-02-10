<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */
    'accepted' => ':attribute 必须接受。',
    'active_url' => ':attribute 不是一个有效的网址。',
    'after' => ':attribute 必须要晚于 :date。',
    'after_or_equal' => ':attribute 必须要等于 :date 或更晚。',
    'alpha' => ':attribute 只能由字母组成。',
    'alpha_dash' => ':attribute 只能由字母、数字和斜杠组成。',
    'alpha_num' => ':attribute 只能由字母和数字组成。',
    'array' => ':attribute 必须是一个数组。',
    'before' => ':attribute 必须要早于 :date。',
    'before_or_equal' => ':attribute 必须要等于 :date 或更早。',
    'between' => [
        'numeric' => ':attribute 必须介于 :min - :max 之间。',
        'file' => ':attribute 必须介于 :min - :max kb 之间。',
        'string' => ':attribute 必须介于 :min - :max 个字符之间。',
        'array' => ':attribute 必须只有 :min - :max 个单元。',
    ],
    'boolean' => ':attribute 必须为布尔值。',
    'confirmed' => ':attribute 两次输入不一致。',
    'date' => ':attribute 不是一个有效的日期。',
    'date_format' => ':attribute 的格式必须为 :format。',
    'different' => ':attribute 和 :other 必须不同。',
    'digits' => ':attribute 必须是 :digits 位的数字。',
    'digits_between' => ':attribute 必须是介于 :min 和 :max 位的数字。',
    'dimensions' => ':attribute 图片尺寸不正确。',
    'distinct' => ':attribute 已经存在。',
    'email' => ':attribute 不是一个合法的邮箱。',
    'exists' => ':attribute 不存在。',
    'file' => ':attribute 必须是文件。',
    'filled' => ':attribute 不能为空。',
    'image' => ':attribute 必须是图片。',
    'in' => '已选的属性 :attribute 非法。',
    'in_array' => ':attribute 没有在 :other 中。',
    'integer' => ':attribute 必须是整数。',
    'ip' => ':attribute 必须是有效的 IP 地址。',
    'json' => ':attribute 必须是正确的 JSON 格式。',
    'max' => [
        'numeric' => ':attribute 不能大于 :max。',
        'file' => ':attribute 不能大于 :max kb。',
        'string' => ':attribute 不能大于 :max 个字符。',
        'array' => ':attribute 最多只有 :max 个单元。',
    ],
    'mimes' => ':attribute 必须是一个 :values 类型的文件。',
    'mimetypes' => ':attribute 必须是一个 :values 类型的文件。',
    'min' => [
        'numeric' => ':attribute 必须大于等于 :min。',
        'file' => ':attribute 大小不能小于 :min kb。',
        'string' => ':attribute 至少为 :min 个字符。',
        'array' => ':attribute 至少有 :min 个单元。',
    ],
    'not_in' => '已选的属性 :attribute 非法。',
    'numeric' => ':attribute 必须是一个数字。',
    'present' => ':attribute 必须存在。',
    'regex' => ':attribute 格式不正确。',
    'required' => ':attribute 不能为空。',
    'required_if' => '当 :other 为 :value 时 :attribute 不能为空。',
    'required_unless' => '当 :other 不为 :value 时 :attribute 不能为空。',
    'required_with' => '当 :values 存在时 :attribute 不能为空。',
    'required_with_all' => '当 :values 存在时 :attribute 不能为空。',
    'required_without' => '当 :values 不存在时 :attribute 不能为空。',
    'required_without_all' => '当 :values 都不存在时 :attribute 不能为空。',
    'same' => ':attribute 和 :other 必须相同。',
    'size' => [
        'numeric' => ':attribute 大小必须为 :size。',
        'file' => ':attribute 大小必须为 :size kb。',
        'string' => ':attribute 必须是 :size 个字符。',
        'array' => ':attribute 必须为 :size 个单元。',
    ],
    'string' => ':attribute 必须是一个字符串。',
    'timezone' => ':attribute 必须是一个合法的时区值。',
    'unique' => ':attribute 已经存在。',
    'uploaded' => ':attribute 上传失败。',
    'url' => ':attribute 格式不正确。',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention 'attribute.rule' to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of 'email'. This simply helps us make messages a little cleaner.
    |
    */
    'attributes' => [
        //自定义验证字段名称
        'name' => '用户名',
        'username' => '用户名',
        'password' => '密码',
        'start_date' => '开始日期',
        'end_date' => '结束日期',
        'start_time' => '上班时间',
        'end_time' => '下班时间',
        'page' => '页码',
        'item' => '条数',
        'role_id' => '角色ID',
        'role_name' => '角色标识',
        'role_display_name' => '角色名称',
        'role_description' => '角色描述',
        'permission_id' => '权限ID',
        'permission_name' => '权限标识',
        'permission_display_name' => '权限名称',
        'permission_description' => '权限描述',
        'perm_allot_status' => '权限分配状态',
        'leave_id' => '请假ID',
        'leave_id_arr' => '请假ID数组',
        'leave_start_time' => '请假开始时间',
        'leave_end_time' => '请假结束时间',
        'leave_type' => '请假类型',
        'leave_status' => '请假状态',
        'leave_reason' => '请假原因',
        'sign_apply_date' => '补签日期',
        'sign_apply_type' => '补签类型',
        'sign_apply_reason' => '补签原因',
        'sign_apply_id' => '补签申请ID',
        'sign_apply_id_arr' => '补签申请ID数组',
        'approval_note' => '审核说明',
        'sign_apply_status' => '补签申请状态',
        'family_id' => '家庭成员ID',
        'family_name' => '家庭成员姓名',
        'family_relation' => '家庭成员关系',
        'family_phone' => '家庭成员电话',
        'certificate_id' => '执业证书ID',
        'certificate_name' => '执业证书名称',
        'certificate_number' => '执业证书编号',
        'continue_password' => '延续注册密码',
        'study_password' => '继续再教育密码',
        'change_password' => '变更密码',
        'admininfo_pic_id' => '附件ID',
        'admininfo_pic_name' => '附件名称',
        'files' => '文件数据',
        'realname' => '真实姓名',
        'birthday' => '出生年月',
        'cardno' => '身份证号',
        'phone' => '电话',
        'address' => '地址',
        'school' => '毕业学校',
        'major' => '所学专业',
        'graduate_date' => '毕业时间',
        'work_year' => '工作年限',
        'level_type' => '职称类别',
        'work_start_date' => '入职时间',
        'remark' => '备注',
        'work_resume' => '工作简历',
        'study_resume' => '学习简历',
        'performance' => '工作业绩',
        'rewards' => '奖惩情况',
        'adminsex' => '性别ID',
        'education_id' => '学历ID',
        'level_id' => '职称ID',
        'department_id' => '部门ID',
        'admin_level_id' => '职务ID',
        'technical_level_id' => '技术职务ID',
        'work_status' => '工作状态ID',
        'admin_profession' => '负责专业类型',
        'company_id' => '公司ID',
        'company_name' => '公司名称',
        'company_type' => '公司类型',
        'company_bankname' => '公司开户行',
        'company_taxnumber' => '公司税号',
        'company_cardno' => '公司开户行卡号',
        'company_orgcode' => '公司组织机构代码',
        'company_contact' => '公司联系人',
        'company_phone' => '公司联系人手机号码',
        'contract_id' => '合同ID',
        'contract_name' => '合同名称',
        'contract_type' => '合同类型',
        'contract_number' => '合同编号',
        'construction_id' => '建设单位ID',
        'agency_id' => '委托单位ID',
        'contract_content' => '合同内容',
        'contract_remark' => '合同备注',
        'sign_date' => '签订时间',
        'cattachment_name' => '合同附件名称',
        'sonproject_id' => '子项目ID',
        'project_id' => '项目ID',
        'service_id' => '服务类型ID',
        'profession' => '专业类型数据',
        'profession_id' => '专业类型ID',
        'cost' => '收费基数',
        'receive_date' => '接收时间',
        'implement_id' => '施工单位ID',
        'son_marcher_id' => '专项实施人ID',
        'basic_rate' => '基础提成',
        'check_rate' => '考核提成',
        'check_mark' => '审核说明',
        'check_cost' => '核定基数',
        'project_check_rate' => '核定率',
        'project_basic_rate' => '基础费率',
        'check_cost_rate' => '核定费率',
        'min_profit' => '最小收费',
        'receipt_date' => '收款日期',
        'allot_year' => '分配年度',
        'money' => '金额',
        'allot_id' => '分配金额ID',
        'income_id' => '收入金额ID',

    ],

    //自定义验证规则

];