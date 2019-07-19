package bracathon.com.bracathon;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import bracathon.com.bracathon.program_operator.PoLogin;
import bracathon.com.bracathon.teacher.FaceActivity;
import bracathon.com.bracathon.teacher.TeacherDashboard;
import bracathon.com.bracathon.teacher.TeacherLogin;

public class MainActivity extends AppCompatActivity {

    private Button teacherbtn,pobtn,branchbtn;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        teacherbtn = (Button) findViewById(R.id.teacherBtn);
        pobtn = (Button) findViewById(R.id.poBtn);
        branchbtn = (Button) findViewById(R.id.branchBtn);

        teacherbtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(getApplicationContext(),TeacherLogin.class));
            }
        });

        pobtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(getApplicationContext(), FaceActivity.class));
            }
        });

        branchbtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

            }
        });




    }
}
