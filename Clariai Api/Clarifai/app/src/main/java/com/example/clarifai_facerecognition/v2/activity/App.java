package com.example.clarifai_facerecognition.v2.activity;

import android.app.Application;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;

import com.example.clarifai_facerecognition.R;

import java.util.concurrent.TimeUnit;

import clarifai2.api.ClarifaiBuilder;
import clarifai2.api.ClarifaiClient;
import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import timber.log.Timber;

public class App extends Application {
    private static App INSTANCE;

    @NonNull
    public static App get() {
        final App instance = INSTANCE;
        if (instance == null) {
            throw new IllegalStateException("App has not been created yet!");
        }
        return instance;
    }

    @Nullable
    private ClarifaiClient client;

    @Override
    public void onCreate() {
        INSTANCE = this;
        client = new ClarifaiBuilder(getString(R.string.Clarifai_Api_Key))
                .client(new OkHttpClient.Builder().readTimeout(30, TimeUnit.SECONDS)
                        .addInterceptor(new HttpLoggingInterceptor(new HttpLoggingInterceptor.Logger() {
                            @Override public void log(String logString) {
                                Timber.e(logString);
                            }
                        }).setLevel(HttpLoggingInterceptor.Level.BODY))
                        .build()).buildSync();
        super.onCreate();

        Timber.plant(new Timber.DebugTree());
    }

    @NonNull
    public ClarifaiClient clarifaiClient() {
        final ClarifaiClient client = this.client;
        if (client == null) {
            throw new IllegalStateException("Cannot use Clarifai client before initialized");
        }
        return client;
    }

}
