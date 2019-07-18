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
import java.util.HashMap;
import java.util.List;
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
    int school;
    int user;
    String username;
    private Button testB;
    List<Double> arr ;
    List<Double> performence ;;
    BarChart barChart;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        arr = new ArrayList<>();
        performence = new ArrayList<>();
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
        Toast.makeText(getApplicationContext(),Integer.toString(user),Toast.LENGTH_LONG).show();
        Log.d("Check",Integer.toString(user));
        username =extras.getString("username");
        testB.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                arr.clear();
                performence.clear();
                getValue();
            }
        });



        //Add single bar


    }
    private void getValue(){
       // progressDialog.show();
         barChart = (BarChart) findViewById(R.id.attendance_bar_chart);
        barChart.setBarMaxValue(100);
        Toast.makeText(getApplicationContext(),Data.school_id,Toast.LENGTH_SHORT).show();
        Toast.makeText(getApplicationContext(),Data.user_id,Toast.LENGTH_LONG).show();
        StringRequest stringRequest = new StringRequest(
                Request.Method.GET,
                Constant.teacher_dashboard+"?id="+Integer.parseInt(Data.user_id)+"&school="+Integer.parseInt(Data.school_id),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                       // progressDialog.dismiss();
                        try {
                            Log.d("Check","["+response+"]");
                            JSONObject obj = new JSONObject(response);
                            if(!obj.getBoolean("error")){

                                arr.add((double) obj.getInt("major"));
                                arr.add((double) obj.getInt("minor"));
                                arr.add((double) obj.getInt("normal"));
                                performence.add((double) obj.getInt("a"));
                                performence.add((double) obj.getInt("b"));
                                performence.add((double) obj.getInt("c"));
                                JSONArray bal = obj.getJSONArray("student");
                                for(int i =0;i<bal.length();i++)
                                    Log.d("Check",bal.getString(i));
                                    //Toast.makeText(getApplicationContext(),bal.getString(i), Toast.LENGTH_LONG).show();
                                JSONArray ho = obj.getJSONArray("attendence");
                                for(int i =0;i<bal.length();i++)
                                    Log.d("Check",ho.getString(i));
                                BarChartModel barChartModel = new BarChartModel();
                                double  major = arr.get(0);
                                double minor = arr.get(1);
                                double normal =arr.get(2);

                                barChartModel.setBarValue((int)major);
                                barChartModel.setBarText("Major");
                                barChartModel.setBarColor(Color.parseColor("#9C27B0"));
                                barChart.addBar(barChartModel);
                                BarChartModel barChartModel1 = new BarChartModel();
                                barChartModel1.setBarValue((int)minor);
                                barChartModel1.setBarText("Minor");
                                barChartModel1.setBarColor(Color.parseColor("#9C27B0"));
                                barChart.addBar(barChartModel1);
                                //finish();
                                BarChartModel barChartModel2 = new BarChartModel();
                                barChartModel2.setBarValue((int)normal);
                                barChartModel2.setBarText("Normal");
                                barChartModel2.setBarColor(Color.parseColor("#9C27B0"));
                                barChart.addBar(barChartModel2);
                                //Toast.makeText(getApplicationContext(),Double.toString(arr.get(2)), Toast.LENGTH_LONG).show();
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
        Toast.makeText(getApplicationContext(),Double.toString(arr.size()), Toast.LENGTH_LONG).show();




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
