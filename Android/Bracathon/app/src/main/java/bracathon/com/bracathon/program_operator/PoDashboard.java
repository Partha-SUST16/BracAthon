package bracathon.com.bracathon.program_operator;

import android.content.Intent;
import android.graphics.Color;
import android.support.annotation.NonNull;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.Toast;

import bracathon.com.bracathon.R;
import bracathon.com.bracathon.teacher.AddStudent;
import bracathon.com.bracathon.teacher.TeacherDashboard;
import bracathon.com.bracathon.teacher.TeacherProfile;
import me.ithebk.barchart.BarChart;
import me.ithebk.barchart.BarChartModel;

public class PoDashboard extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private ActionBarDrawerToggle actionBarDrawerToggle;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_po_dashboard);

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
                    Toast.makeText(PoDashboard.this,"My Profile CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id==R.id.menuMyProfile)
                {
                    Toast.makeText(PoDashboard.this,"My Profile CLICKED",Toast.LENGTH_SHORT).show();
                    startActivity(new Intent(getApplicationContext(),PoProfile.class));
                }
                else if(id==R.id.menuEditProfile)
                {
                    Toast.makeText(PoDashboard.this,"Edit Profile CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id==R.id.menuTeacherList)
                {
                    Toast.makeText(PoDashboard.this,"Teacher List Clicked",Toast.LENGTH_SHORT).show();
                }
                else if(id == R.id.menuAddTeacher)
                {
                    Toast.makeText(PoDashboard.this,"Add teacher CLICKED",Toast.LENGTH_SHORT).show();
                    startActivity(new Intent(getApplicationContext(),AddTeacher.class));
                }
                else if(id == R.id.menuLogout)
                {
                    Toast.makeText(PoDashboard.this,"Log Out CLICKED",Toast.LENGTH_SHORT).show();
                }
                return true;
            }
        });

        ///Drawer & NavigationBar ends.

        BarChart barChart = (BarChart) findViewById(R.id.attendance_bar_chart);
        barChart.setBarMaxValue(100);

        //Add single bar
        BarChartModel barChartModel;

        for(int i=0;i<10;i++){
            barChartModel = new BarChartModel();
            if(i%2==1){
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
