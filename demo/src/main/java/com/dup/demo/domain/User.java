package com.dup.demo.domain;

import com.dup.demo.domain.group.First;
import com.dup.demo.domain.group.Second;

import javax.validation.constraints.NotEmpty;

public class User {
    @NotEmpty(message = "用户ID不能为空", groups = {First.class})
    private Long id;
    @NotEmpty(message = "用户名不能为空", groups = {First.class, Second.class})
    private String name;
    @NotEmpty(message = "密码不能为空", groups = {First.class, Second.class})
    private String password;

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

    @Override
    public String toString() {
        return "User{" +
                "id=" + id +
                ", name='" + name + '\'' +
                ", password='" + password + '\'' +
                '}';
    }
}
