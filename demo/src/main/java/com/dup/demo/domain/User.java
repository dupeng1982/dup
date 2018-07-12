package com.dup.demo.domain;

import com.dup.demo.domain.group.First;
import com.dup.demo.domain.group.Second;
import org.hibernate.validator.constraints.ScriptAssert;

import javax.validation.constraints.NotEmpty;

@ScriptAssert(lang = "javascript", script = "com.dup.demo.domain.User.checkParams(_this.type,_this.status)",
        message = "自定义验证测试", groups = {First.class, Second.class})
public class User {
    @NotEmpty(message = "{user.id.notEmpty}", groups = {First.class})
    private Long id;
    @NotEmpty(message = "{user.name.notEmpty}", groups = {First.class, Second.class})
    private String name;
    @NotEmpty(message = "{user.password.notEmpty}", groups = {First.class, Second.class})
    private String password;

    private Integer type;
    private Integer status;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public Integer getType() {
        return type;
    }

    public void setType(Integer type) {
        this.type = type;
    }

    public Integer getStatus() {
        return status;
    }

    public void setStatus(Integer status) {
        this.status = status;
    }

    @Override
    public String toString() {
        return "User{" +
                "id=" + id +
                ", name='" + name + '\'' +
                ", password='" + password + '\'' +
                '}';
    }

    public static boolean checkParams(Integer type, Integer status) {
        if ((status != null) && (status > 1) && (type != null)) {
            return true;
        } else {
            return false;
        }
    }

}
