package bracathon.com.bracathon.teacher;

import android.content.Context;
import android.support.annotation.NonNull;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.List;

import bracathon.com.bracathon.R;
import clarifai2.dto.prediction.Concept;

public class CustomAdapter extends RecyclerView.Adapter<CustomAdapter.Holder> {

    Context context;
    @NonNull private List<Concept> concepts = new ArrayList<>();

    public CustomAdapter(@NonNull List<Concept> concepts, Context ctx) {
        this.context = ctx;
        this.concepts = concepts;
        notifyDataSetChanged();
    }

    public CustomAdapter setData(@NonNull List<Concept> concepts) {
        this.concepts = concepts;
        notifyDataSetChanged();
        return this;
    }

    @NonNull
    @Override
    public Holder onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {
        LayoutInflater inflater = LayoutInflater.from(context);
        View v = inflater.inflate(R.layout.item_concept,null);
        return new Holder(v);
    }

    @Override
    public void onBindViewHolder(@NonNull Holder holder, int position) {
        Concept concept = concepts.get(position);

        holder.name.setText(concept.name() != null ? concept.name() : concept.id());
        if(concept.value()>0.25){
            holder.predictionResult.setText("1");

            Data.attendence = Data.attendence+","+(concept.name() != null ? concept.name() : concept.id());
            Toast.makeText(context,Data.attendence,Toast.LENGTH_SHORT).show();
        }
        else{
            holder.predictionResult.setText("0");
        }

    }

    @Override
    public int getItemCount() {
        return concepts.size();
    }

    public class Holder extends RecyclerView.ViewHolder{

        TextView name ,predictionResult;

        public Holder(@NonNull View itemView) {
            super(itemView);

            name = itemView.findViewById(R.id.prediction_name);
            predictionResult = itemView.findViewById(R.id.prediction_probability);
        }
    }
}
