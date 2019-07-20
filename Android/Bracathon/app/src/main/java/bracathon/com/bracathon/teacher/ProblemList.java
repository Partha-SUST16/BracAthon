package bracathon.com.bracathon.teacher;

public class ProblemList {
    private String id,date,catagory,details,status;

    public ProblemList(String id, String date, String catagory, String details, String status) {
        this.id = id;
        this.date = date;
        this.catagory = catagory;
        this.details = details;
        this.status = status;
    }

    public ProblemList() {
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getCatagory() {
        return catagory;
    }

    public void setCatagory(String catagory) {
        this.catagory = catagory;
    }

    public String getDetails() {
        return details;
    }

    public void setDetails(String details) {
        this.details = details;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}
