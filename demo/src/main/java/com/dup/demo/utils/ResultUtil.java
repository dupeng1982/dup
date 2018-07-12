package com.dup.demo.utils;

import com.dup.demo.domain.Result;
import com.dup.demo.enums.ExceptionEnum;

public class ResultUtil {
    public static Result success(Object object) {
        Result result = new Result();
        result.setCode(ExceptionEnum.SUCCESS.getCode());
        result.setMsg(ExceptionEnum.SUCCESS.getMsg());
        result.setData(object);
        return result;
    }

    public static Result success() {
        return success(null);
    }

    public static Result error(Integer code, String msg) {
        Result result = new Result();
        result.setCode(code);
        result.setMsg(msg);
        return result;
    }
}
