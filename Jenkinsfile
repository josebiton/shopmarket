pipeline {
    agent any

    stages {
        stage('Preparacion') {
            steps {
                git branch: 'main', url: 'https://github.com/josebiton/prunac.git'
                echo 'Pulled from github successfully'
            }
        }
        
        stage('Instalar dependencias') {
            steps {
                sh 'sudo apt install composer'
            }
        }
        
        stage('Verifica version php') {
            steps {
                sh 'php --version'
            }
        }

        stage('Ejecutar php') {
            steps {
                sh 'php index.php'
            }
        }

        //Revisa la calidad de código con SonarQube
        //stage ('Sonarqube') {
        //    steps {
        //        script {
        //            def scannerHome = tool name: 'sonarscanner', type: 'hudson.plugins.sonar.SonarRunnerInstallation';
        //            echo "scannerHome = $scannerHome ...."
        //            withSonarQubeEnv() {
        //                sh "$scannerHome/bin/sonar-scanner"
        //            }
        //        }
        //    }
        //}
    }
}

