package com.dup.demo.enums;

public enum ExceptionEnum {
    UNKOWN_ERROR(-3, "未知错误"),
    NULL_POINTER_ERROR(-2, "空值错误"),
    ERROR(-1, "系统错误"),
    SUCCESS(0, "success"),
    ARGS_ERROR(10000, "参数非法");
    private Integer code;

    private String msg;

    ExceptionEnum(Integer code, String msg) {
        this.code = code;
        this.msg = msg;
    }

    public Integer getCode() {
        return code;
    }

    public String getMsg() {
        return msg;
    }

    public void setMsg(String msg) {
        this.msg = msg;
    }

}
