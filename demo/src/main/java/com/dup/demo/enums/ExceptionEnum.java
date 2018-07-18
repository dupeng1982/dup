package com.dup.demo.enums;

public enum ExceptionEnum {
    UNKOWN_ERROR(-4, "未知错误"),
    USERNAME_NOT_FOUND_ERROR(-3, "用户不存在"),
    NULL_POINTER_ERROR(-2, "参数校验错误"),
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
