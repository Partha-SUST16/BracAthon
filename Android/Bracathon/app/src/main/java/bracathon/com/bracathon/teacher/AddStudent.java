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

public class AddStudent extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private ActionBarDrawerToggle actionBarDrawerToggle;
    private EditText bName,bFather,bMother,bPhone,bBatch,bGender,bAddress;
    private Button signup;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_student);

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
                else if(id==R.id.menuEditProfile)
                {
                    Toast.makeText(AddStudent.this,"Edit Profile CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id==R.id.menuStudentList)
                {
                    Toast.makeText(AddStudent.this,"Student List Clicked",Toast.LENGTH_SHORT).show();
                }
                else if(id == R.id.menuAddStudent)
                {
                    Toast.makeText(AddStudent.this,"Add Student CLICKED",Toast.LENGTH_SHORT).show();
                    //startActivity(new Intent(getApplicationContext(),AddStudent.class));
                }
                else if(id == R.id.menuLogout)
                {
                    Toast.makeText(AddStudent.this,"Log Out CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id == R.id.menuAddProblem)
                {
                    startActivity(new Intent(getApplicationContext(),AddProblem.class));
                }
                else if(id == R.id.menuAddPerformance)
                {
                    startActivity(new Intent(getApplicationContext(),AddPerformance.class));
                }
                return true;
            }
        });

        ///Drawer & NavigationBar ends.
        bName = findViewById(R.id.studentNameId);
        bFather = findViewById(R.id.studentFatherNameID);
        bMother = findViewById(R.id.studentMotherNameID);
        bPhone = findViewById(R.id.studentPhoneID);
        bBatch = findViewById(R.id.studentBatchNoID);
        bGender = findViewById(R.id.studentgenderID);
        bAddress = findViewById(R.id.studentAddressID);
        signup = findViewById(R.id.studentSignUpBtn);

        signup.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                process();
            }
        });


    }

    private void process(){
        final String name = bName.getText().toString().trim();
        final String father = bFather.getText().toString().trim();
        final String mother = bMother.getText().toString().trim();
        final String phone = bPhone.getText().toString().trim();
        final String address = bAddress.getText().toString().trim();
        final String gender = bGender.getText().toString().trim();
        final String batch = bBatch.getText().toString().trim();

        ////////////////////////////////////////////////////
        StringRequest stringRequest = new StringRequest(
                Request.Method.POST,
                Constant.create_student+"?school="+Integer.parseInt(Data.school_id),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.d("Check","["+response+"]");
                            Toast.makeText(getApplicationContext(),"Success",Toast.LENGTH_SHORT).show();
                            JSONObject obj = new JSONObject(response);
                        } catch (JSONException e) {
                            Log.d("ErrorHI","["+e.getMessage()+"]");
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(
                                getApplicationContext(),
                                "["+error.getMessage()+"",
                                Toast.LENGTH_LONG
                        ).show();
                        Log.d("Error","["+error.getMessage()+"]");
                    }
                }
        ){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                /*
                $name = $_POST['name'];
		$father = $_POST['father'];
		$mother = $_POST['mother'];
		$address = $_POST['address'];
		$phone  = $_POST['phone'];
		$batch = $_POST['batch'];
		$gender = $_POST['gender'];
                */
                params.put("name",name);
                params.put("father",father);
                params.put("mother",mother);
                params.put("address",address);
                params.put("phone",phone);
                params.put("batch",batch);
                params.put("gender",gender);


                return params;
            }

        };

        RequestHandler.getInstance(this).addToRequestQueue(stringRequest);


        ///////////////////////////////////////////////////
    }


    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        return actionBarDrawerToggle.onOptionsItemSelected(item) ||super.onOptionsItemSelected(item);
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
