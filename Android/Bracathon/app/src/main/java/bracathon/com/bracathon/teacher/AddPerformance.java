package bracathon.com.bracathon.teacher;

import android.content.Intent;
import android.support.annotation.NonNull;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import bracathon.com.bracathon.Constant;
import bracathon.com.bracathon.R;
import bracathon.com.bracathon.RequestHandler;
import bracathon.com.bracathon.program_operator.PoProfile;

public class AddPerformance extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private ActionBarDrawerToggle actionBarDrawerToggle;

    private EditText studentID,examID,subjectName,grade;
    private Button insert;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_performance);

        drawerLayout = (DrawerLayout) findViewById(R.id.teacherDrawerID);
        actionBarDrawerToggle = new ActionBarDrawerToggle(this,drawerLayout,R.string.Open,R.string.Close);
        actionBarDrawerToggle.setDrawerIndicatorEnabled(true);

        drawerLayout.addDrawerListener(actionBarDrawerToggle);
        actionBarDrawerToggle.syncState();
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        NavigationView navigationView = (NavigationView) findViewById(R.id.TeacherNavigationID);
        navigationView.setNavigationItemSelectedListener(new NavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                int id = item.getItemId();

                if(id==R.id.menuMyDashboard)
                {
                    startActivity(new Intent(getApplicationContext(),TeacherDashboard.class));
                }
                else if(id==R.id.menuMyProfile)
                {
                    startActivity(new Intent(getApplicationContext(),TeacherProfile.class));
                }
                else if(id==R.id.menuAttendance)
                {
                    Toast.makeText(AddPerformance.this," Attendance CLICKED",Toast.LENGTH_SHORT).show();
                    startActivity(new Intent(getApplicationContext(),FaceActivity.class));
                }
                else if(id==R.id.menuStudentList)
                {
                    Toast.makeText(AddPerformance.this,"Student List Clicked",Toast.LENGTH_SHORT).show();
                }
                else if(id == R.id.menuAddStudent)
                {
                    startActivity(new Intent(getApplicationContext(),AddStudent.class));
                }
                else if(id == R.id.menuLogout)
                {
                    Toast.makeText(AddPerformance.this,"Log Out CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id == R.id.menuAddProblem)
                {
                    startActivity(new Intent(getApplicationContext(),AddProblem.class));
                }
                else if(id == R.id.menuProblemList)
                {
                    startActivity(new Intent(getApplicationContext(),ProblemView.class));
                }
                else if(id == R.id.menuAddPerformance)
                {
                    //startActivity(new Intent(getApplicationContext(),AddPerformance.class));
                }
                return true;
            }
        });

        ///Drawer & NavigationBar ends.


        studentID = (EditText) findViewById(R.id.selectStudentID);
        examID = (EditText) findViewById(R.id.selectExamID);
        subjectName = (EditText) findViewById(R.id.selectSubjectID);
        grade = (EditText) findViewById(R.id.selectGradeID);
        insert = (Button) findViewById(R.id.insertbtnId);

        insert.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                insertProcess();
            }
        });


    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        return actionBarDrawerToggle.onOptionsItemSelected(item) ||super.onOptionsItemSelected(item);
    }

    private void insertProcess(){
        String id = studentID.getText().toString().trim();
        final String exam = examID.getText().toString().trim();
        final String subject  = subjectName.getText().toString().trim();
        final String Grade = grade.getText().toString().trim();

        StringRequest stringRequest = new StringRequest(
                Request.Method.POST,
                Constant.performence+"?id="+Integer.parseInt(id)+"&school="+Integer.parseInt(Data.school_id),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        //progressDialog.dismiss();
                        try {
                            Log.d("Check","["+response+"]");
                            JSONObject obj = new JSONObject(response);
                            if(!obj.getBoolean("error")){
                                Toast.makeText(getApplicationContext(),"Successfull", Toast.LENGTH_LONG).show();
                                //finish();
                            }else{
                                Toast.makeText(
                                        getApplicationContext(),
                                        obj.getString("message"),
                                        Toast.LENGTH_LONG
                                ).show();
                                Log.d("Error","["+obj.getString("message")+"]");
                            }
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
        ){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                params.put("exam", exam);
                params.put("subject", subject);
                params.put("grade",Grade);
                return params;
            }

        };

        RequestHandler.getInstance(this).addToRequestQueue(stringRequest);
    }
    @Override
    public void onBackPressed() {
        if(drawerLayout.isDrawerOpen(GravityCompat.START)){
            drawerLayout.closeDrawer(GravityCompat.START);
        }
        else{
            super.onBackPressed();
        }
    }
}
