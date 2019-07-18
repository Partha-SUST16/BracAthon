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
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import bracathon.com.bracathon.R;

public class TeacherProfile extends AppCompatActivity {

    private TextView teacherName, teacherSchool, teacherGender, teacherAddress, teacherBranch,
            teacherArea,teacherRegion,teacherPo,teacherPhone;
    int schoolid,userid;
    String username;

    private DrawerLayout drawerLayout;
    private ActionBarDrawerToggle actionBarDrawerToggle;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_teacher_profile);


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
                    Toast.makeText(TeacherProfile.this,"My Profile CLICKED",Toast.LENGTH_SHORT).show();
                    Intent i = new Intent(getApplicationContext(),TeacherDashboard.class);
                    i.putExtra("userid",userid);
                    i.putExtra("schoolid",schoolid);
                    i.putExtra("username",username);
                    startActivity(i);
                }
                else if(id==R.id.menuMyProfile)
                {
                    Toast.makeText(TeacherProfile.this,"My Profile CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id==R.id.menuEditProfile)
                {
                    Toast.makeText(TeacherProfile.this,"Edit Profile CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id==R.id.menuStudentList)
                {
                    Toast.makeText(TeacherProfile.this,"Student List Clicked",Toast.LENGTH_SHORT).show();
                }
                else if(id == R.id.menuAddStudent)
                {
                    Toast.makeText(TeacherProfile.this,"Add Student CLICKED",Toast.LENGTH_SHORT).show();
                    startActivity(new Intent(getApplicationContext(),AddStudent.class));
                }
                else if(id == R.id.menuLogout)
                {
                    Toast.makeText(TeacherProfile.this,"Log Out CLICKED",Toast.LENGTH_SHORT).show();
                }
                return true;
            }
        });

        ///Drawer & NavigationBar ends.


        teacherName = (TextView)findViewById(R.id.teacherNameID);
        teacherSchool =(TextView) findViewById(R.id.schoolNameID);
        teacherGender = (TextView)findViewById(R.id.teacherGenderID);
        teacherAddress = (TextView)findViewById(R.id.teacherAddressID);
        teacherBranch = (TextView)findViewById(R.id.branchNameID);
        teacherArea = (TextView)findViewById(R.id.areaNameID);
        teacherRegion = (TextView)findViewById(R.id.regionNameID);
        teacherPo = (TextView)findViewById(R.id.poNameID);
        teacherPhone = (TextView)findViewById(R.id.teacherPhoneID);
        ini();


    }



    private void ini(){
        try {
            JSONObject obj = new JSONObject(getIntent().getStringExtra("information"));
            teacherName.setText(obj.getString("teacher_name"));
            teacherSchool.setText(obj.getString("school_name"));
            teacherPhone.setText(obj.getString("phone"));
            teacherPo.setText(obj.getString("po_name"));
            teacherAddress.setText(obj.getString("address"));
            teacherGender.setText(obj.getString("gender"));
            Data.school_id = obj.getString("school_id");
            Data.user_id = obj.getString("teacher_id");
        } catch (JSONException e) {
            e.printStackTrace();
        }
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
