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
import android.widget.Toast;

import bracathon.com.bracathon.R;

public class AddTeacher extends AppCompatActivity {

    private DrawerLayout drawerLayout;
    private ActionBarDrawerToggle actionBarDrawerToggle;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_teacher);

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
                    Toast.makeText(AddTeacher.this,"My Profile CLICKED",Toast.LENGTH_SHORT).show();
                    startActivity(new Intent(getApplicationContext(),PoDashboard.class));
                }
                else if(id==R.id.menuMyProfile)
                {
                    Toast.makeText(AddTeacher.this,"My Profile CLICKED",Toast.LENGTH_SHORT).show();
                    startActivity(new Intent(getApplicationContext(),PoProfile.class));
                }
                else if(id==R.id.menuEditProfile)
                {
                    Toast.makeText(AddTeacher.this,"Edit Profile CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id==R.id.menuTeacherList)
                {
                    Toast.makeText(AddTeacher.this,"Teacher List Clicked",Toast.LENGTH_SHORT).show();
                }
                else if(id == R.id.menuAddTeacher)
                {
                    Toast.makeText(AddTeacher.this,"Add teacher CLICKED",Toast.LENGTH_SHORT).show();
                }
                else if(id == R.id.menuLogout)
                {
                    Toast.makeText(AddTeacher.this,"Log Out CLICKED",Toast.LENGTH_SHORT).show();
                }
                return true;
            }
        });

        ///Drawer & NavigationBar ends.

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
