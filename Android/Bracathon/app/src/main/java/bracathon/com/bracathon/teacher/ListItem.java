package bracathon.com.bracathon.teacher;

public class ListItem {
    String name;
    Double predictionResult;

    public ListItem(String name, Double predictionResult) {
        this.name = name;
        this.predictionResult = predictionResult;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public Double getPredictionResult() {
        return predictionResult;
    }

    public void setPredictionResult(Double predictionResult) {
        this.predictionResult = predictionResult;
    }
}
