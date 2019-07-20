package bracathon.com.bracathon.teacher;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.NetworkResponse;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

import bracathon.com.bracathon.Constant;
import bracathon.com.bracathon.R;
import bracathon.com.bracathon.RequestHandler;

public class StudentView extends AppCompatActivity {

    private RecyclerView recyclerView;
    private StudentAdapter studentAdapter;
    private List addList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_student_view);
        recyclerView = findViewById(R.id.studentView);
        addList = new ArrayList<>();

        recyclerView.setHasFixedSize(true);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        studentAdapter = new StudentAdapter(this,addList);
        recyclerView.setAdapter(studentAdapter);

        getInfo();

    }
    private void getInfo(){
        StringRequest stringRequest = new StringRequest(
                Request.Method.GET,
                Constant.studentlist+"?school="+Integer.parseInt(Data.school_id),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        // progressDialog.dismiss();
                        try {
                            Log.d("Check","["+response+"]");
                            JSONObject obj = new JSONObject(response);
                            JSONArray arr = (JSONArray) obj.get("student");
                            for(int i=0;i<arr.length();i++){
                                JSONObject data = (JSONObject) arr.get(i);
                                Log.d("Adapter",data.getString("name"));
                                StudentList temp = new StudentList(data.getString("name"),data.getString("gender"),data.getString("id"));
                                addList.add(temp);
                                studentAdapter.notifyDataSetChanged();
                            }
                            Log.d("size",Integer.toString(addList.size()));

                        } catch (JSONException e) {
                            Log.d("Error","["+e.getMessage()+"]");
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        //progressDialog.dismiss();

                        Toast.makeText(
                                getApplicationContext(),
                                "["+error.getMessage()+"]",
                                Toast.LENGTH_LONG
                        ).show();
                        Log.d("Error","["+error.getMessage()+"]");
                    }
                }
        ) {
            @Override
            protected Response<String> parseNetworkResponse(NetworkResponse response) {
                if (response.headers == null)
                {
                    // cant just set a new empty map because the member is final.
                    response = new NetworkResponse(
                            response.statusCode,
                            response.data,
                            Collections.<String, String>emptyMap(), // this is the important line, set an empty but non-null map.
                            response.notModified,
                            response.networkTimeMs);


                }

                return super.parseNetworkResponse(response);
            }

        };

        RequestHandler.getInstance(this).addToRequestQueue(stringRequest);
    }
}
