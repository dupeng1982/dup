package com.dup.demo.domain;

import com.dup.demo.domain.group.First;
import com.dup.demo.domain.group.Second;

import javax.validation.constraints.NotEmpty;

public class User {
    @NotEmpty(message = "{user.id.notEmpty}", groups = {First.class})
    private Long id;
    @NotEmpty(message = "{user.name.notEmpty}", groups = {First.class, Second.class})
    private String name;
    @NotEmpty(message = "{user.password.notEmpty}", groups = {First.class, Second.class})
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
