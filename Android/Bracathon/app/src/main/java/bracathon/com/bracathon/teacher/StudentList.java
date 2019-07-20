package bracathon.com.bracathon.teacher;

public class StudentList {
    private String name,gender,id;

    public StudentList(String name, String gender, String id) {
        this.name = name;
        this.gender = gender;
        this.id = id;
    }

    public StudentList() {
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getGender() {
        return gender;
    }

    public void setGender(String gender) {
        this.gender = gender;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }
}
