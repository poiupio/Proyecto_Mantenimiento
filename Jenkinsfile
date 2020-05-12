pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Building..'
            }
        }
        stage('Test') {
            steps {
                catchError {
                    echo 'Testing..'
                    bat 'vendor/bin/phpunit --bootstrap ./vendor/autoload.php core/tests --debug --log-junit results/phpunit.xml'
                }
            }
            post {
                success {
                    echo 'Testing successful'
                    bat 'D: & cd %PROY_URL% & git pull origin'

                }
                failure {
                    echo 'Testing stage failed'
                }
            }
        }
        stage('Deploy') {
            steps {
                echo 'Deploying....'
            }
        }
    }
}