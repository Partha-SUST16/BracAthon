package bracathon.com.bracathon.program_operator;

import android.content.Intent;
import android.support.annotation.NonNull;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import bracathon.com.bracathon.R;
import bracathon.com.bracathon.teacher.AddStudent;
import bracathon.com.bracathon.teacher.TeacherDashboard;
import bracathon.com.bracathon.teacher.TeacherProfile;

public class PoProfile extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private ActionBarDrawerToggle actionBarDrawerToggle;
    private TextView name,phone,address,gender,branch;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_po_profile);

        drawerLayout = (DrawerLayout) findViewById(R.id.poDrawerID);
        actionBarDrawerToggle = new ActionBarDrawerToggle(this,drawerLayout,R.string.Open,R.string.Close);
        actionBarDrawerToggle.setDrawerIndicatorEnabled(true);

        drawerLayout.addDrawerListener(actionBarDrawerToggle);
        actionBarDrawerToggle.syncState();
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        NavigationView navigationView = (NavigationView) findViewById(R.id.PoNavigationID);
        navigationView.setNavigationItemSelectedListener(new NavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                int id = item.getItemId();

                if(id==R.id.menuMyDashboard)
                {
                    Toast.makeText(PoProfile.this,"My Profile CLICKED",Toast.LENGTH_SHORT).show();
                    startActivity(new Intent(getApplicationContext(),PoDashboard.class));
                }
                else if(id==R.id.menuMyProfile)
                {
                    Toast.makeText(PoProfile.this,"My Profile CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id==R.id.menuEditProfile)
                {
                    Toast.makeText(PoProfile.this,"Edit Profile CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id==R.id.menuTeacherList)
                {
                    Toast.makeText(PoProfile.this,"Teacher List Clicked",Toast.LENGTH_SHORT).show();
                }
                else if(id == R.id.menuAddTeacher)
                {
                    Toast.makeText(PoProfile.this,"Add teacher CLICKED",Toast.LENGTH_SHORT).show();
                    startActivity(new Intent(getApplicationContext(),AddTeacher.class));
                }
                else if(id == R.id.menuLogout)
                {
                    Toast.makeText(PoProfile.this,"Log Out CLICKED",Toast.LENGTH_SHORT).show();
                }
                return true;
            }
        });

        ///Drawer & NavigationBar ends.

        name = findViewById(R.id.poNameid);
        phone = findViewById(R.id.poPhone);
        address = findViewById(R.id.poAddress);
        gender = findViewById(R.id.poGender);
        branch = findViewById(R.id.poBranch);
        ini();

    }
    private void ini(){
        try {
            JSONObject obj = new JSONObject(getIntent().getStringExtra("information"));
            name.setText(obj.getString("name"));
            phone.setText(obj.getString("phone"));
            gender.setText(obj.getString("gender"));
            branch.setText(obj.getString("branch"));
            address.setText(obj.getString("address"));
            // bracathon.com.bracathon.teacher.Data.school_id = obj.getString("school_id");
            //Data.user_id = obj.getString("id");
            DataPO.user_id = obj.getString("id");
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
