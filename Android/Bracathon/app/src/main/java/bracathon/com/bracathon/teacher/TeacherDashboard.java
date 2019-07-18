package bracathon.com.bracathon.teacher;

import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Color;
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
import bracathon.com.bracathon.MainActivity;
import bracathon.com.bracathon.R;
import bracathon.com.bracathon.RequestHandler;
import bracathon.com.bracathon.SharedPrefManager;
import me.ithebk.barchart.BarChart;
import me.ithebk.barchart.BarChartModel;

public class TeacherDashboard extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private ActionBarDrawerToggle actionBarDrawerToggle;
    private ProgressDialog progressDialog;
    private SharedPrefManager sharedPrefManager;
    int school,user;
    private Button testB;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_teacher_dashboard);
        sharedPrefManager = SharedPrefManager.getInstance(getApplicationContext());
        testB = findViewById(R.id.test);
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
                    Toast.makeText(TeacherDashboard.this,"My Profile CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id==R.id.menuMyProfile)
                {
                    Toast.makeText(TeacherDashboard.this,"My Profile CLICKED",Toast.LENGTH_SHORT).show();
                    startActivity(new Intent(getApplicationContext(),TeacherProfile.class));
                }
                else if(id==R.id.menuEditProfile)
                {
                    Toast.makeText(TeacherDashboard.this,"Edit Profile CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id==R.id.menuStudentList)
                {
                    Toast.makeText(TeacherDashboard.this,"Student List Clicked",Toast.LENGTH_SHORT).show();
                }
                else if(id == R.id.menuAddStudent)
                {
                    Toast.makeText(TeacherDashboard.this,"Add Student CLICKED",Toast.LENGTH_SHORT).show();
                    startActivity(new Intent(getApplicationContext(),AddStudent.class));
                }
                else if(id == R.id.menuLogout)
                {
                    Toast.makeText(TeacherDashboard.this,"Log Out CLICKED",Toast.LENGTH_SHORT).show();
                }
                return true;
            }
        });

        ///Drawer & NavigationBar ends.
        Bundle extras = getIntent().getExtras();
        school = (int) extras.getInt("schoolid");
        user = extras.getInt("userid");
        testB.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getValue();
            }
        });

        BarChart barChart = (BarChart) findViewById(R.id.attendance_bar_chart);
        barChart.setBarMaxValue(100);

        //Add single bar
        BarChartModel barChartModel;

        for(int i=0;i<10;i++){
            barChartModel = new BarChartModel();
            if(i%2==0){
                barChartModel.setBarValue(50+i*5);
                barChartModel.setBarText(""+(50+i*5));
            }
            else{
                barChartModel.setBarValue(50-i*5);
                barChartModel.setBarText(""+(50-i*5));
            }

            barChartModel.setBarColor(Color.parseColor("#9C27B0"));
            barChartModel.setBarTag(null); //You can set your own tag to bar model
            barChart.addBar(barChartModel);
        }
    }
    private void getValue(){
       // progressDialog.show();
        StringRequest stringRequest = new StringRequest(
                Request.Method.POST,
                Constant.teacher_dashboard,
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
                                        obj.getString("message")+"HELLO",
                                        Toast.LENGTH_LONG
                                ).show();
                                Log.d("ErrorHI","["+obj.getString("message")+"]");
                            }
                        } catch (JSONException e) {
                            Log.d("ErrorJO","["+e.getMessage()+"]");
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        //progressDialog.dismiss();

                        Toast.makeText(
                                getApplicationContext(),
                                "["+error.getMessage()+"]"+"522",
                                Toast.LENGTH_LONG
                        ).show();
                        Log.d("ErrorHl","["+error.getMessage()+"]");
                    }
                }
        ){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                params.put("userid",Integer.toString(user));
                params.put("schoolid", Integer.toString(school));
                return params;
            }

        };

        RequestHandler.getInstance(this).addToRequestQueue(stringRequest);
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
