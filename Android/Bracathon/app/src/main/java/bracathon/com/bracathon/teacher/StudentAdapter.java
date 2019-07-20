package bracathon.com.bracathon.teacher;

import android.content.Context;
import android.support.annotation.NonNull;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.List;

import bracathon.com.bracathon.R;

public class StudentAdapter extends RecyclerView.Adapter<StudentAdapter.MyViewHolder> {
    private Context mCtx;
    private List<StudentList> studentList;

    public StudentAdapter(Context mCtx, List<StudentList> studentList){
        this.mCtx = mCtx;
        this.studentList = studentList;
    }
    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {
        View view = LayoutInflater.from(mCtx).inflate(R.layout.student_adapter, null);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder myViewHolder, int i) {
        StudentList info = studentList.get(i);
        myViewHolder.gender.setText("Gender: "+info.getGender());
        myViewHolder.name.setText("Name: "+info.getName());
        myViewHolder.id.setText("ID: "+info.getId());
    }

    @Override
    public int getItemCount() {
        return studentList.size();
    }

    public class MyViewHolder  extends RecyclerView.ViewHolder {
        TextView name,id,gender;
        public MyViewHolder(View view) {
            super(view);
            name = view.findViewById(R.id.studentName);
            id = view.findViewById(R.id.studentID);
            gender = view.findViewById(R.id.studentGeder);

        }
    }
}
