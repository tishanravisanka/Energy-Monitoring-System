package com.programming.dsproject.authservice.entity;

        import jakarta.persistence.Table;
        import lombok.AllArgsConstructor;
        import lombok.Data;
        import lombok.NoArgsConstructor;

        import jakarta.persistence.Entity;
        import jakarta.persistence.Id;

@Entity
@Table(name = "users")
@NoArgsConstructor
@AllArgsConstructor
@Data
public class Users {
    @Id
    private int id;
    private String name;
    private String email;
    private String password;

}
