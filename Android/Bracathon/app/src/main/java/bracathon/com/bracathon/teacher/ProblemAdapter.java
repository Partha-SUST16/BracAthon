package bracathon.com.bracathon.teacher;

import android.content.Context;
import android.support.annotation.NonNull;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.HashMap;
import java.util.List;

import bracathon.com.bracathon.R;

public class ProblemAdapter extends RecyclerView.Adapter<ProblemAdapter.MyViewHolder_> {
    private Context mCtx;
    private List<ProblemList> problemList;
    private HashMap<String,String>mp = new HashMap<>();

    public ProblemAdapter(Context mCtx, List<ProblemList> problemList){
        this.mCtx = mCtx;
        mp.put("t","approved");
        mp.put("f","Not approved");
        this.problemList = problemList;
    }
    @NonNull
    @Override
    public MyViewHolder_ onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {
        View view = LayoutInflater.from(mCtx).inflate(R.layout.problem_adapter, null);
        return new MyViewHolder_(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder_ myViewHolder, final int i) {
        ProblemList info = problemList.get(i);
        myViewHolder.id.setText("ID: "+info.getId());
        myViewHolder.status.setText("Status: "+mp.get(info.getStatus()));
        myViewHolder.date.setText("Date: "+info.getDate());
        myViewHolder.catagory.setText("Category :"+info.getCatagory());
        myViewHolder.details.setText("Details: "+info.getDetails());
    }

    @Override
    public int getItemCount() {
        return problemList.size();
    }

    public class MyViewHolder_  extends RecyclerView.ViewHolder {
        TextView id,date,catagory,details,status;
        public MyViewHolder_(View view) {
            super(view);
            id = view.findViewById(R.id.pID);
            date = view.findViewById(R.id.pdate);
            catagory = view.findViewById(R.id.pcatagory);
            details =view.findViewById(R.id.pdetails);
            status = view.findViewById(R.id.pstatus);
        }
    }
}
