package com.dup.demo.service;

import com.dup.demo.domain.User;
import com.dup.demo.mapper.UserMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;

import java.util.List;

@Service("userService")
public class UserService {
    @Autowired
    private UserMapper userMapper;

    public List<User> getAllUser() {
        return userMapper.getAllUser();
    }

    public User getOneUser(Long id) {
        return userMapper.getOneUser(id);
    }

    public int addUser(User user) {
        return userMapper.addUser(user);
    }

    public int createUser(User user) {
        BCryptPasswordEncoder encoder =new BCryptPasswordEncoder();
        user.setPassword(encoder.encode(user.getPassword().trim()));
        return userMapper.createUser(user);
    }
}
