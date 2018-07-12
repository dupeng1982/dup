package com.dup.demo.validator;

import org.thymeleaf.util.StringUtils;

import javax.validation.ConstraintValidator;
import javax.validation.ConstraintValidatorContext;

public class ForbiddenWordValidatorClass implements ConstraintValidator<ForbiddenWordValidator, Object> {
    private String values;

    @Override
    public void initialize(ForbiddenWordValidator forbiddenWordValidator) {
        this.values = forbiddenWordValidator.values();
    }

    @Override
    public boolean isValid(Object value, ConstraintValidatorContext constraintValidatorContext) {
        String[] value_array = values.split(",");
        String value_tmp = (String) value;
        boolean isFlag = false;
        if (StringUtils.isEmpty(value_tmp)) {
            isFlag = true;
        } else {
            isFlag = true;
            for (String word : value_array) {
                if (value_tmp.contains(word)) {
                    isFlag = false;
                    break;
                }
            }
        }
        return isFlag;
    }
}
