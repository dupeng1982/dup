package com.dup.demo.exception;

import com.dup.demo.enums.ExceptionEnum;

public class AppException extends RuntimeException {
    private Integer code;

    public AppException(ExceptionEnum exceptionEnum) {
        super(exceptionEnum.getMsg());
        this.code = exceptionEnum.getCode();
    }

    public Integer getCode() {
        return code;
    }

    public void setCode(Integer code) {
        this.code = code;
    }
}
